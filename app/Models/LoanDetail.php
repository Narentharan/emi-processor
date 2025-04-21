<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    protected $fillable = [
        'clientid',
        'loan_amount',
        'num_of_payment',
        'first_payment_date',
        'last_payment_date'
    ];
}
