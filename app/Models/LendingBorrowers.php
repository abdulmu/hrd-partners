<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public $timestamps = false;

}
