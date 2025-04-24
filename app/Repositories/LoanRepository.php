<?php
namespace App\Repositories;

use App\Models\LoanDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LengthException;

class LoanRepository
{
    public function getAll(): Collection
    {
        return LoanDetail::all();
    }

    public function getMinPaymentDate(): ?string
    {
        return LoanDetail::min('first_payment_date');
    }

    public function getMaxPaymentDate(): ?string
    {
        return LoanDetail::max('last_payment_date');
    }

    public function paginate($perPage = 10): LengthAwarePaginator
    {
        return LoanDetail::paginate($perPage);
    }
}
