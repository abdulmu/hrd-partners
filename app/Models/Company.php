<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    public $connection = 'pgsql2';

    protected $fillable = [
        'id','name','phone_number','email','pic','status','automatic_status','created_at','updated_at','account_bank_id','account_name','account_number'
    ];
    
    public static function list_company(){

        $data = DB::connection('pgsql2')->table('companies')->select('id','name','')->get();

        return $data;
    }

    public static function getNextId()
    {
        $lastProduct = DB::connection('pgsql2')->table('companies')->orderBy('id', 'desc')->limit(1)->first();
        return $lastProduct ? $lastProduct->id + 1 : 1;
    }

}
