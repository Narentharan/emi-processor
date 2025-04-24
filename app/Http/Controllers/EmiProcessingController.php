<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Services\EmiProcessingService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmiProcessingController extends Controller
{
    protected $emiService;

    public function __construct(EmiProcessingService $emiService)
    {
        $this->emiService = $emiService;
    }

    public function index(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $emiData = Schema::hasTable('emi_details') ? DB::table('emi_details')->paginate(10) : [];
        return view('emi.index', compact('emiData'));
    }

    public function process(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to perform this action.');
        }

        $this->emiService->process();
        return redirect()->route('emi.index')->with('success', 'EMI Table Processed!');
    }
}

