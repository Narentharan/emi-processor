<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Carbon\Carbon;


class EmiProcessingController extends Controller
{
    public function index()
    {
        $emiData = [];

        if (Schema::hasTable('emi_details')) {
            $emiData = DB::table('emi_details')->get();
        }

        return view('emi.index', compact('emiData'));
    }

    public function process(Request $request)
    {
        // Drop existing emi_details table
        Schema::dropIfExists('emi_details');

        // Get min first date and max last date
        $minDate = Carbon::parse(LoanDetail::min('first_payment_date'))->startOfMonth();
        $maxDate = Carbon::parse(LoanDetail::max('last_payment_date'))->startOfMonth();

        // Generate month columns
        $columns = [];
        while ($minDate <= $maxDate) {
            $columns[] = $minDate->format('Y_M');
            $minDate->addMonth();
        }

        // Create table with dynamic columns
        $createSQL = "CREATE TABLE emi_details (clientid INT";

        foreach ($columns as $col) {
            $createSQL .= ", `$col` DECIMAL(10,2) DEFAULT 0.00";
        }
        $createSQL .= ")";
        DB::statement($createSQL);

        // Fill data row-by-row
        $loans = LoanDetail::all();

        foreach ($loans as $loan) {
            $emiAmount = round($loan->loan_amount / $loan->num_of_payment, 2);
            $emiList = [];

            $start = Carbon::parse($loan->first_payment_date)->startOfMonth();
            for ($i = 0; $i < $loan->num_of_payment; $i++) {
                $monthKey = $start->format('Y_M');
                if (!isset($emiList[$monthKey])) {
                    $emiList[$monthKey] = 0;
                }
                $emiList[$monthKey] += $emiAmount;
                $start->addMonth();
            }

            // Adjust last EMI if needed
            $sum = array_sum($emiList);
            $diff = round($loan->loan_amount - $sum, 2);
            if ($diff !== 0) {
                $lastKey = array_key_last($emiList);
                $emiList[$lastKey] += $diff;
            }

            // Insert into emi_details
            $insert = ['clientid' => $loan->clientid];
            foreach ($columns as $col) {
                $insert[$col] = $emiList[$col] ?? 0.00;
            }

            DB::table('emi_details')->insert($insert);
        }

        return redirect()->route('emi.index')->with('success', 'EMI Table Processed!');
    }
}
