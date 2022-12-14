<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MasterProductInterest extends Model
{
    use HasFactory;
    protected $table = 'master_product_interest';
    public $connection = 'pgsql2';


    protected $fillable = [
        'id',
        'product_id',
        'interest_code',
        'interest_type_id',
        'interest_rate_type_id'
    ];

    public function getNextId()
    {
        $lastProduct = DB::table('master_product_interest')->orderBy('id', 'desc')->limit(1)->first();
        return $lastProduct ? $lastProduct->id + 1 : 1;
    }

    public static function getFilterData($id)
    {
        $data = DB::table('master_products')
        ->select('master_product_interest.id','product_name','interest_code','master_products.created_at')
        ->join('master_product_interest', 'master_product_interest.product_id', '=', 'master_products.id')
        ->where('master_product_interest.product_id', $id);
        // ->get();

        return $data;
    }
}
