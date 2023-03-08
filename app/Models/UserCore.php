<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCore extends Model
{
    use HasFactory;
    protected $table = 'borrowers';

    public $connection = 'pgsql2';


    public $primaryKey = 'id';
    protected $fillable = [
                'id',
                'user_phone_number_id',
                'application_id',
                'workplace_address',
                'monthly_expense',
                'montly_gross_income',
                'income_source',
                'number_of_dependants',
                'marital_status',
                'spouse_identity_number',
                'spouse_name',
                'spouse_birthdate',
                'mother_name',
                'status_of_residence',
                'length_of_residence',
                'score',
                'balance',
                'created_at',
                'length_of_working',
                'monthly_non_permanent_expense',
                'savings_ratio',
                'liquidity_months',
                'loan_ratio',
                'others_loan_status',
                'spouse_income_source',
                'others_loan_installment',
                'others_loan_approved',
                'bank_id',
                'bank_account_name',
                'bank_account_number',
                'number',
                'saving_money',
                'savings_assets',
                'envelope_status',
                'business_name',
                'business_desc',
                'year_of_estabilishment',
                'business_field',
                'business_certificate_number',
                'number_of_employess',
                'family_card_foto',
                'selfie_with_saving_book',
                'salary_slip_foto',
                'ig_account',
                'fb_account',
                'type',
                'businessaddress',
                'polish_number',
                'bpjs_number',
                'bpjs_foto',
                'employee_card_foto',
                'ec_relationship',
                'ec_name',
                'ec_phone_number',
                'ec_email',
                'ec_address',
                'ec_postal_code',
                'ec_village',
                'ec_district',
                'ec_city',
                'ec_province',
                'ec_identity_number',
                'ec_identity_foto',
                'code',
                'other_income',
                'spouse_job_id',
                'business_image',
                'business_status',
                'business_ownership',
                'business_monthly_turnover',
                'business_sector_id',
                'business_province_id',
                'business_city_id',
                'business_district_id',
                'business_subdistrict_id',
                'plafon',
                'plafon_active',
                'monthly_income',
                'monthly_fixed_expense',
                'monthly_net_income',
                'other_monthly_income',
                'va_wallet',
                'business_entity_code',
                'lender_business_id',
                'company_id',
                'plafon_rejected_at'  
            ];

    protected $hidden = [
        // 'password',
        'remember_token',
    ];
    protected $guarded = [];
    public $timestamps = false;


    private const GENDER_MALE = 'Laki-Laki';
    private const GENDER_FEMALE = 'Perempuan';
    private const GENDER_LEGAL_ENTITY = 'Badan Hukum';

    private const GENDER_CODE = [
        self::GENDER_MALE => 1,
        self::GENDER_FEMALE => 2,
        self::GENDER_LEGAL_ENTITY => 3,
    ];

    public const KYC_STATUS_NOT_VERIFIED = 'not_verified';
    public const KYC_STATUS_PENDING = 'pending';
    public const KYC_STATUS_VERIFIED = 'verified';
    public const KYC_STATUS_REJECTED = 'rejected';

    public const ENVELOPE_STATUS_NOT_ACTIVE = 'belum aktif';
    public const ENVELOPE_STATUS_ACTIVE = 'aktif';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
