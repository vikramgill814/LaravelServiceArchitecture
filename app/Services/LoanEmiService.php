<?php
namespace App\Services;

use App\Repositories\LoanDetailRepository;
use Illuminate\Support\Facades\DB;

class LoanEmiService
{
    protected $loanDetailRepo;

    public function __construct(LoanDetailRepository $loanDetailRepo)
    {
        $this->loanDetailRepo = $loanDetailRepo;
    }

    public function processLoanData()
    {
        // Get min and max payment dates
        $minDate = $this->loanDetailRepo->getMinFirstPaymentDate();
        $maxDate = $this->loanDetailRepo->getMaxLastPaymentDate();

        // Drop and create the emi_details table
        $this->createEmiDetailsTable($minDate, $maxDate);

        // Process each loan and calculate EMI
        $loans = $this->loanDetailRepo->getLoans();
        foreach ($loans as $loan) {
            $this->insertEmiData($loan, $minDate, $maxDate);
        }
    }

    protected function createEmiDetailsTable($minDate, $maxDate)
    {
        DB::statement('DROP TABLE IF EXISTS emi_details');

        $columns = $this->generateMonthColumns($minDate, $maxDate);

        $createTableQuery = 'CREATE TABLE emi_details (clientid BIGINT, ' . $columns . ')';
        DB::statement($createTableQuery);
    }

    protected function generateMonthColumns($minDate, $maxDate)
    {
        $columns = '';
        $start = strtotime($minDate);
        $end = strtotime($maxDate);

        while ($start <= $end) {
            $monthYear = date('Y_M', $start);
            $columns .= "{$monthYear} DECIMAL(15, 2), ";
            $start = strtotime('+1 month', $start);
        }

        return rtrim($columns, ', ');
    }

    protected function insertEmiData($loan)
    {
        $startPaymentDate = new \DateTime($loan->first_payment_date);

        $endPaymentDate =  new \DateTime($loan->last_payment_date);
        //modify start date to first day of month to avoid 29 feb issue if year is not leap year
        $startPaymentDate->modify('first day of this month');
        $endPaymentDate->modify('first day of this month');
        $numPayments = $loan->num_of_payment;
        $loanAmount = $loan->loan_amount;
        $monthlyEmi = round($loanAmount / $numPayments, 2);
    
        $data = [];
    
        // Track the number of payments made
        $remainingAmount = $loanAmount;
        $paymentCount = 0;
    
        // Loop through the months from first_payment_date to last_payment_date
        $currentDate = $startPaymentDate;
        while ($currentDate <= $endPaymentDate && $paymentCount < $numPayments) {
            $monthYear = $currentDate->format('Y_M');
            // Insert the EMI amount into this month
            $emi = min($monthlyEmi, $remainingAmount);
            $data[$monthYear] = $emi;
    
            // Deduct from remaining amount
            $remainingAmount -= $emi;
            $paymentCount++;
    
           // Move to the next month
            $currentDate->modify('+1 month');
        }
    
        // Insert EMI data for this loan into the emi_details table
        $this->loanDetailRepo->insertEmiDetails($loan->clientid, $data);
    }
    
     // Get EMI details for displaying in the form
     public function getEmiDetails()
     {
         return $this->loanDetailRepo->getAllEmis();
     }
}
