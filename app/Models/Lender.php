<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lender extends Model
{
    use HasFactory;
    protected $table = 'lenders';
    public $connection = 'pgsql2';

    protected $fillable = [
        'id',
        'application_id',
        'balance',
        'active_portfolio_count',
        'portfolio_count',
        'total_interest_earned',
        'active_balance',
        'created_at',
        'active_returned_principal',
        'active_pending_principal',
        'active_returned_interest',
        'active_pending_interest',
        'version',
        'total_lending_amount',
        'agreement',
        'updated_at',
        'envelope_id',
        'envelope_status',
        'agreement_number',
        'total_principal_earned',
        'agreement_number_sk',
        'salary_slip',
        'type',
        'length_of_residence',
        'status_of_residence',
        'marital_status',
        'facebook',
        'instagram',
        'monthly_income',
        'lender_business_id',
        'created_by',
        'code',
        'monthly_fixed_expense',
        'monthly_net_income',
        'other_monthly_income',
        'business_entity_code',
        'va_wallet',
        'business_id',
        'lender_agreement_sign',
        'lender_agreement_sent',
        'lender_agreement_date',
        'lender_return_type',
        'agreement_sent_at',
        'agreement_expired_at',
        'super_lender_bag',
        'active_super_lender_bag'
    ];

}
