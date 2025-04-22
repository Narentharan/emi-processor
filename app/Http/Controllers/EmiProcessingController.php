<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\EmiProcessingService;

class EmiProcessingController extends Controller
{
    protected $emiService;

    public function __construct(EmiProcessingService $emiService)
    {
        $this->emiService = $emiService;
    }

    public function index()
    {
        $emiData = Schema::hasTable('emi_details') ? DB::table('emi_details')->get() : [];
        return view('emi.index', compact('emiData'));
    }

    public function process(Request $request)
    {
        $this->emiService->process();
        return redirect()->route('emi.index')->with('success', 'EMI Table Processed!');
    }
}
