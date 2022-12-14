<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lending extends Model
{
    use HasFactory;

    protected $table = 'lendings';
    public $connection = 'pgsql2';

    /** When lending was created by group and wait for group confirmation  */
    public const STATUS_WAITING_GROUP_CONFIRMATION = 'wait_group_confirm';

    /** When lending is scoring process  */
    public const STATUS_SCORING = 'scoring';

    /** When lending is created  */
    public const STATUS_ANALYSIST = 'analysist';

    /** When lending is waiting to sign  */
    public const STATUS_WAITING_SIGNATURE_AGREEMENT = 'wait_sign_agreement';

    /** When funding is available  */
    public const STATUS_OPENED = 'opened';

    /** When fund is given to borrower */
    public const STATUS_DISBURSED = 'disbursed';

    /** When fund is returned by borrower */
    public const STATUS_RETURNED = 'returned';

    /** When funding amount completed */
    public const STATUS_FUNDED = 'funded';

    /** When funding amount not completed, then refunded to lender */
    public const STATUS_REFUNDED = 'refunded';

    /** When repayment amount not completed, then write off */
    public const STATUS_WRITE_OFF = 'write_off';

    /** When repayment amount not completed, then restrukturisasi */
    public const STATUS_RESTRUKTURISASI = 'restrukturisasi';

    /** When lending failed by confirmation member */
    public const STATUS_REJECT_MEMBER = 'reject_member';

    /** When lending failed because scoring borrower */
    public const STATUS_REJECT_SCORING = 'reject_scoring';

    /** When lending rejected */
    public const STATUS_REJECT = 'reject';

    public const STATUS_ASSIGN = 'assign';

    public const STATUS_DATA = [
        self::STATUS_WAITING_GROUP_CONFIRMATION => 'Menunggu Konfirmasi Anggota',
        self::STATUS_SCORING => 'Analisa Skor Peminjam',
        self::STATUS_ANALYSIST => 'Dianalisa',
        self::STATUS_OPENED => 'Menunggu Pendanaan',
        self::STATUS_DISBURSED => 'Aktif',
        self::STATUS_RETURNED => 'Lunas',
        self::STATUS_FUNDED => 'Terdanai',
        self::STATUS_REFUNDED => 'Ditolak',
        self::STATUS_WRITE_OFF => 'Dihapus',
        self::STATUS_RESTRUKTURISASI => 'Restrukturisasi',
        self::STATUS_REJECT_MEMBER => 'Konfirmasi Anggota Gagal',
        self::STATUS_REJECT_SCORING => 'Konfirmasi Scoring Gagal'
    ];

    public const TENOR_UNIT_YEAR = 'yearly';
    public const TENOR_UNIT_WEEK = 'weekly';
    public const TENOR_UNIT_MONTH = 'monthly';
    public const TENOR_UNIT_DAY = 'daily';

    public const TYPE_GROUP = 'group';
    public const TYPE_BUSINESS = 'business';
    public const TYPE_BUSINESS_ENTITY = 'business_entity';
    public const TYPE_PERSONAL = 'personal';
    public const TYPE_DATA = [
        self::TYPE_GROUP => 'Kelompok',
        self::TYPE_BUSINESS => 'Perusahaan',
        self::TYPE_PERSONAL => 'Pribadi',
        self::TYPE_PERSONAL => 'Individu',
        self::TYPE_BUSINESS_ENTITY => 'Badan Usaha',
    ];

    protected $guarded = [];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(MasterProduct::class, 'product_id', 'id');
    }

    public function lending_borrowers()
    {
        return $this->hasMany(LendingBorrower::class);
    }

    public function master_product_interest_item()
    {
        return $this->hasOne(MasterProductInterestItem::class, 'id', 'product_interest_item_id');
    }

    public function disbursement()
    {
        return $this->belongsTo(Disbursement::class);
    }

    public function lending_other_costs()
    {
        return $this->hasMany(LendingOtherCost::class);
    }

    public function tenorConverter()
    {
        switch ($this->tenor_unit) {
            case 'yearly':
                $tenorUnit = 'Tahun';
                break;
            case 'monthly':
                $tenorUnit = 'Bulan';
                break;
            case 'weekly':
                $tenorUnit = 'Minggu';
                break;
            case 'daily':
                $tenorUnit = 'Hari';
                break;
            default:
                $tenorUnit = '-';
                break;
        }

        return sprintf('%s %s', $this->period, $tenorUnit);
    }

    public function interestConverter($formatted = false)
    {
        $interestRatePerDay = 0;
        $interestRatePerDay = $this->interest_percentage / 360;

        if ($formatted) {
            return round($interestRatePerDay, 3) . ' % / Hari';
        }

        return round($interestRatePerDay, 3);
    }

    public function statusConvert()
    {
        if (in_array($this->status, array_keys(self::STATUS_DATA))) {
            return self::STATUS_DATA[$this->status];
        }

        return '-';
    }

    public function getInterestPercentagePerDay($formatted = false)
    {
        $total = null;
        if ($this->tenor_unit == self::TENOR_UNIT_DAY) {
            $interest = $this->interest_percentage / 360;
            $total = round($interest, 3);
        } else if ($this->tenor_unit == self::TENOR_UNIT_WEEK) {
            $interest = $this->interest_percentage / 360;
            $total = round($interest, 3);
        } else if ($this->tenor_unit == self::TENOR_UNIT_MONTH) {
            $interest = $this->interest_percentage / 360;
            $total = round($interest, 3);
        } else if ($this->tenor_unit == self::TENOR_UNIT_YEAR) {
            $interest = $this->interest_percentage / 360;
            $total = round($interest, 3);
        } else {
            $total = 0;
        }

        if ($formatted) {
            return $total . ' % / Hari';
        }

        return $total;
    }

    public function getInterestAmount()
    {
        if ($this->tenor_unit == self::TENOR_UNIT_DAY) {
            $interest = $this->interest_percentage / 360;
            return $this->period * ($this->loan_amount * $interest / 100);
        } else if ($this->tenor_unit == self::TENOR_UNIT_WEEK) {
            $interest = $this->interest_percentage / 360;
            return ($this->period * 7) * ($this->loan_amount * $interest / 100);
        } else if ($this->tenor_unit == self::TENOR_UNIT_MONTH) {
            $interest = $this->interest_percentage / 360;
            return ($this->period * 30) * ($this->loan_amount * $interest / 100);
        } else if ($this->tenor_unit == self::TENOR_UNIT_YEAR) {
            $interest = $this->interest_percentage / 360;
            return ($this->period * 360) * ($this->loan_amount * $interest / 100);
        } else {
            return 0;
        }
    }

    public static function Datalist(){

        $data = DB::connection('pgsql2')->table('lending_borrowers')
                ->select('users.name','received_amount','lending_borrowers.id','lending_borrowers.loan_code','lendings.created_at')
                ->join('lendings', 'lendings.id', '=', 'lending_borrowers.lending_id')
                ->join('borrowers', 'borrowers.id', '=', 'lending_borrowers.lending_id')
                ->join('users', 'users.borrower_id', '=', 'borrowers.id')
                ->get();

        return $data;
    }

    public static function Getlist($id){

        $data = DB::connection('pgsql2')->table('lending_borrowers')
                 ->select('id')

                ->select('users.name','received_amount','lending_borrowers.id','lending_borrowers.loan_code','lendings.created_at')
                ->join('lendings', 'lendings.id', '=', 'lending_borrowers.lending_id')
                ->join('borrowers', 'borrowers.id', '=', 'lending_borrowers.borrower_id')
                ->join('users', 'users.borrower_id', '=', 'borrowers.id')
                ->where('lending_borrowers.id',$id)
                ->first();

        return $data;
    }
}
