<?php

namespace App\Http\Controllers;

use App\Repositories\LoanRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LoanDetailsController extends Controller
{
    protected $loanRepo;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
    }

        try {
            $loans = $this->loanRepo->paginate(10); 
            return view('loan-details.index', compact('loans'));
    }   catch (\Exception $e) {
            Log::error('Failed to load loan details: ' . $e->getMessage());
            return back()->withErrors('Something went wrong while fetching loan details.');
    }
}


}
