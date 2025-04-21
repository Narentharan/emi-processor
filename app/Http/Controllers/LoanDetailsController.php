<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoanDetail;
use Illuminate\Http\Request;


class LoanDetailsController extends Controller
{
    public function index()
    {
        $loans = LoanDetail::all();
        return view('loan-details.index', compact('loans'));
    }
}
