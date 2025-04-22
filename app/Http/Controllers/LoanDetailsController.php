<?php

namespace App\Http\Controllers;

use App\Repositories\LoanRepository;

class LoanDetailsController extends Controller
{
    protected $loanRepo;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    public function index()
    {
        $loans = $this->loanRepo->getAll();
        return view('loan-details.index', compact('loans'));
    }
}
