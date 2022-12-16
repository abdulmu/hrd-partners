<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class GeneratorAccesLoan extends Model
{
    use HasFactory;

    protected $table = 'generator_acces_loan';
    public $connection = 'pgsql2';
    protected $fillable = [
        'id',
        'acces_code',
        'status',
        'product_code',
        'created_at',
        'update_at',
        'product_id',
        'created_by',
        'product_interest_item_id',
        'tenor_unit',
        'tenor',
        'user_id'    
    ];

    public static function getNextId()
    {
        $lastProduct = DB::connection('pgsql2')->table('generator_acces_loan')->orderBy('id', 'desc')->limit(1)->first();
        return $lastProduct ? $lastProduct->id + 1 : 1;
    }

    public static function GetAccessLoan($id){

        $cekAktif=DB::connection('pgsql2')->table('generator_acces_loan')
                    ->where('user_id', $id)
                    ->orderBy('id','desc')
                    ->first();


    }

    public $timestamps = false;

}
