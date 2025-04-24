<?php 
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Repositories\LoanRepository;

class EmiProcessingService
{
    protected $loanRepo;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    public function process(): bool
    {
        // Drop existing table
        Schema::dropIfExists('emi_details');

        // Get loan date range
        $minDate = Carbon::parse($this->loanRepo->getMinPaymentDate())->startOfMonth();
        $maxDate = Carbon::parse($this->loanRepo->getMaxPaymentDate())->startOfMonth();

        // Generate month columns
        $columns = [];
        while ($minDate <= $maxDate) {
            $columns[] = $minDate->format('Y_M');
            $minDate->addMonth();
        }

        // Create dynamic EMI table
        $createSQL = "CREATE TABLE emi_details (clientid INT";
        foreach ($columns as $col) {
            $createSQL .= ", `$col` DECIMAL(10,2) DEFAULT 0.00";
        }
        $createSQL .= ")";
        DB::statement($createSQL);

        // Fill data
        $loans = $this->loanRepo->getAll();

        foreach ($loans as $loan) {
            $emiAmount = round($loan->loan_amount / $loan->num_of_payment, 2);
            $emiList = [];

            $start = Carbon::parse($loan->first_payment_date)->startOfMonth();
            for ($i = 0; $i < $loan->num_of_payment; $i++) {
                $monthKey = $start->format('Y_M');
                $emiList[$monthKey] = ($emiList[$monthKey] ?? 0) + $emiAmount;
                $start->addMonth();
            }

            // Adjust for rounding
            $sum = array_sum($emiList);
            $diff = round($loan->loan_amount - $sum, 2);
            if ($diff !== 0) {
                $emiList[array_key_last($emiList)] += $diff;
            }

            // Insert
            $insert = ['clientid' => $loan->clientid];
            foreach ($columns as $col) {
                $insert[$col] = $emiList[$col] ?? 0.00;
            }

            DB::table('emi_details')->insert($insert);
        }

        return true;
    }
}
