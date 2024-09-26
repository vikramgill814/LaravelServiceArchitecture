<?php
namespace App\Http\Controllers;

use App\Services\LoanEmiService;
use Illuminate\Http\Request;

class LoanEmiController extends Controller
{
    protected $loanEmiService;

    public function __construct(LoanEmiService $loanEmiService)
    {
        $this->loanEmiService = $loanEmiService;
    }

    public function showProcessPage()
    {
        
        return view('process_data'); // View with "Process Data" button
    }

    public function processLoanEmi(Request $request)
    {
        // Call the service to process EMI data
        $this->loanEmiService->processLoanData();
        // Get EMI details from the service layer
        $emiDetails = $this->loanEmiService->getEmiDetails()->toArray();
        
        return view('process_data',compact('emiDetails','emiDetails'))->with('success', 'Loan EMI processed successfully.');
    }
}
