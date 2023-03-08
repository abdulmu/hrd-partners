<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Borrowers extends Model
{
    use HasFactory;
    protected $table = 'users';

    public $connection = 'pgsql2';

    protected $primaryKey = 'user_id';
    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';



    protected $fillable = [
        'id',
        'staff_id',
        'application_id',
        'username',
        'password',
        'username_canonical',
        'email',
        'email_canonical',
        'enabled',
        'name',
        'identity_type',
        'kyc_status',
        'created_at',
        'updated_at',
        'platform',
        'salt',
        'plafon',
        'roles',
        'ktp_status',
        'npwp_status',
        'ktp_selfie_status',
        'kyc_error_status', 
        'number_of_dependents'
    ];

    
    protected $casts = [
        'id' => 'int',
    ];



    protected $guarded = [];
    public $timestamps = false;

    private const TYPE_BORROWER_INDIVIDU = 'individu';
    private const TYPE_BORROWER_GROUPS = 'group';
    private const TYPE_BORROWER_BUSINESS_ENTITY = 'business_entity';

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function getData(){

        $data = DB::connection('pgsql2')->table('users')
                ->select('email','name','kyc_status','user_phone_numbers.phone_number','users.id as id')
                ->join('user_phone_numbers', 'user_phone_numbers.id', '=', 'users.user_phone_number_id')
                ->join('borrowers', 'user_phone_numbers.id', '=', 'borrowers.user_phone_number_id')
                ->groupBy('user_phone_numbers.phone_number')
                ->groupBy('users.email')
                ->groupBy('users.name')
                ->groupBy('users.id')
                ->groupBy('users.kyc_status')
                ->get();

        return $data;
    }


    public static function cif(){

        $data = DB::connection('pgsql2')->table('users')
                ->select('email','name','kyc_status','users.id as id','users.created_at','nik')
                ->join('borrowers', 'borrowers.id', '=', 'users.borrower_id');

        return $data;
    }

    public static function kyc(){

        $data = DB::connection('pgsql2')->table('users')
                ->select('email','name','kyc_status','users.id as id','users.created_at','nik','birthday')
                ->join('borrowers', 'borrowers.id', '=', 'users.borrower_id');

        return $data;
    }

    public static function getBorrowers(){

        $data = DB::connection('pgsql2')->table('users')
                ->select('staff_id','borrower_id','email','name','users.id as id','generator_acces_loan.status','acces_code','phone_number')
                ->join('user_phone_numbers', 'user_phone_numbers.id', '=', 'users.user_phone_number_id')
                ->join('borrowers', 'user_phone_numbers.id', '=', 'borrowers.user_phone_number_id')
                ->LeftJoin('generator_acces_loan', 'generator_acces_loan.user_id', '=', 'users.id')
                ->groupBy('users.id')
                ->groupBy('user_phone_numbers.phone_number')
                ->groupBy('generator_acces_loan.status')
                ->groupBy('generator_acces_loan.acces_code')
                ->get();

        return $data;
    }

    public static function getDataBorrowers($id){

        $data = DB::connection('pgsql2')->table('users')
                ->select('staff_id','borrower_id','email','name','birthday','gender','kyc_status','ec_name','ec_phone_number','ec_email','ec_address','ec_village','ec_district','ec_city','ec_province','ec_postal_code','plafon','mother_name','users.monthly_income','plafon_active','business_status','user_phone_numbers.phone_number','gender','users.id as id','users.monthly_income','borrowers.id as borrowerid ','borrowers.plafon')
                ->join('user_phone_numbers', 'user_phone_numbers.id', '=', 'users.user_phone_number_id')
                ->join('borrowers', 'user_phone_numbers.id', '=', 'borrowers.user_phone_number_id')
                ->where('users.id', $id)
                ->first();

        return $data;
    }

    public static function CheckingPlafon($id){

        $data = DB::connection('pgsql2')->table('borrowers')
	            ->select(DB::raw("SUM(received_amount) as total","borrowers.id"))
                ->join('lending_borrowers', 'lending_borrowers.borrower_id', '=', 'borrowers.id')
                ->join('lendings', 'lendings.id', '=', 'lending_borrowers.lending_id')
                ->where('lending_borrowers.borrower_id', $id)
                ->first();

        return $data;
    }

    public function lending_borrowers()
    {
        return $this->hasMany(LendingBorrower::class,'borrower_id','id');
    }
    
}
