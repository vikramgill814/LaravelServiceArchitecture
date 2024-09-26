<?php
namespace App\Repositories;

use App\Models\EmiDetail;
use App\Models\LoanDetail;
use Illuminate\Support\Facades\DB;

class LoanDetailRepository
{
    public function getAllLoans()
    {
        return LoanDetail::all();
    }

    public function getMinFirstPaymentDate()
    {
        return LoanDetail::min('first_payment_date');
    }

    public function getMaxLastPaymentDate()
    {
        return LoanDetail::max('last_payment_date');
    }

    public function getLoans()
    {
        return LoanDetail::all();
    }
    
    public function insertEmiDetails($clientId, $data)
    {
        DB::table('emi_details')->insert([
            'clientid' => $clientId,
            ...$data // dynamically generated columns and data
        ]);
    }
    public function getAllEmis()
    {
        return EmiDetail::all();
    }
}
