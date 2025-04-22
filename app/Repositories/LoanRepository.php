<?php
namespace App\Repositories;

use App\Models\LoanDetail;

class LoanRepository
{
    public function getAll()
    {
        return LoanDetail::all();
    }

    public function getMinPaymentDate()
    {
        return LoanDetail::min('first_payment_date');
    }

    public function getMaxPaymentDate()
    {
        return LoanDetail::max('last_payment_date');
    }
}
