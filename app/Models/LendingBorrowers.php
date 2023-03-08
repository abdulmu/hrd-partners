<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class LendingBorrowers extends Model
{
    use HasFactory;

    protected $table = 'lending_borrowers';
    public $connection = 'pgsql2';

    protected $fillable = [
        'id',
        'lending_id',
        'borrower_id',
        'application_id',
        'unpaid_amount',
        'unpaid_principal',
        'unpaid_interest',
        'unpaid_admin_fee',
        'unpaid_late_charges',
        'payment_amount',
        'disbursement_contract',
        'updated_at',
        'envelope_id',
        'envelope_status',
        'disbursement_contract_number',
        'number',
        'received_amount',
        'status',
        'approved_at',
        'rejected_at',
        'rejected_reason',
        'loan_quality',
        'fdc_inquiry',
        'loan_code',
        'document_id',
        'agreement_number',
        'agreement_file',
        'agreement_sent_at',
        'agreement_signed_at',
        'dpd',
        'first_late_payment_at',
        'disbursed_at',
        'disbursed_amount',
        'pefindo_inquiry',
        'asliri_inquiry',
        'check_scoring_inquiry',
        'link_sign_document'
    ];

    public function lending()
    {
        return $this->belongsTo(Lending::class);
    }
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public static function lendingFunding()
    {
        $data = DB::connection('pgsql2')->table('lending_borrowers')->select('lending_borrowers.id', 'name', 'username', 'email','email','lendings.loan_code','master_products.product_name','lendings.created_at')
        ->join('users', 'users.id', '=', 'lending_borrowers.borrower_id')
        ->join('lendings','lendings.id','=', 'lending_borrowers.lending_id')
        ->join('master_products','master_products.id','=', 'lendings.product_id')
        ->orderBy('users.id', 'desc');

        return $data;
    }

    public static function lendingPaymentSchedule()
    {
        $data = DB::connection('pgsql2')->table('lending_borrowers')->select('lending_borrowers.id', 'name', 'username', 'email','email','lendings.loan_code','master_products.product_name','lending_borrowers.disbursed_at','payment_schedule_borrowers.payment_date')
        ->join('users', 'users.id', '=', 'lending_borrowers.borrower_id')
        ->join('lendings','lendings.id','=', 'lending_borrowers.lending_id')
        ->join('master_products','master_products.id','=', 'lendings.product_id')
        ->join('payment_schedules','payment_schedules.lending_id','=', 'lendings.id')        
        ->join('payment_schedule_borrowers','payment_schedule_borrowers.payment_schedule_id','=', 'payment_schedules.id')        
        // ->where('lendings.status', 'Aktif')
        // ->groupBy('users.id', 'payment_schedule_borrowers')

        ->orderBy('users.id', 'desc');

        return $data;
    }


    public static function lendingFundingParameters($id)
    {
        $data = DB::connection('pgsql2')->table('lending_borrowers')->select('lending_borrowers.id', 'name', 'username', 'email','email','lendings.loan_code','master_products.product_name','lendings.created_at','phone_number','nik','loan_amount','disbursed_amount','lending_borrowers.disbursed_at','bank_account_name','bank_account_number')
        ->join('users', 'users.id', '=', 'lending_borrowers.borrower_id')
        ->join('lendings','lendings.id','=', 'lending_borrowers.lending_id')
        ->join('master_products','master_products.id','=', 'lendings.product_id')
        ->join('borrowers','borrowers.id','=', 'users.borrower_id')
        ->join('user_phone_numbers', 'user_phone_numbers.id', '=', 'users.user_phone_number_id')
        ->where('lending_borrowers.id', $id)
        ->orderBy('users.id', 'desc')->first();

        return $data;
    }

    public $timestamps = false;
}
