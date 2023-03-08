<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MasterProduct extends Model
{
    use HasFactory;
    protected $table = 'master_products';
    public $connection = 'pgsql2';

    protected $fillable = [
        'id',
        'product_group',
        'product_code',
        'product_name',
        'program',
        'work_flow',
        'created_at',
        'description',
        'valid_start',
        'valid_end',
        'status',
        'min_amount',
        'max_amount',
        'product_image',
        'investor',
        'vendor',
        'purpose',
        'category',
        'total_rate_funding',
        'lender_interest',
        'disbursement_type',
        'fee_percentage',
        'tax_percentage',
        'multiple',
        'created_at',
        'update_at'
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    public static function Productlist(){

        $data = DB::connection('pgsql2')->table('master_products')
        ->select('master_products.id','product_name','min_amount','max_amount','master_products.product_code','category')
        ->where('master_products.status', 2)
        ->groupBy('master_products.product_code')
        ->groupBy('master_products.id')
        ->get();

        return $data;
    }
  
    public static function Productlist_id($id){

        $data = DB::connection('pgsql2')->table('master_products')
        ->select('master_products.id','product_name','interest_code','interest_rate','interest_rate_calculation','tenor','tenor_unit','grace_period','min_amount','max_amount','master_products.product_code','description','category','purpose')
        ->join('master_product_interest', 'master_product_interest.product_id', '=', 'master_products.id')
        ->join('master_product_interest_items', 'master_product_interest_items.product_interest_id', '=', 'master_product_interest.id')
        ->where('master_products.id', $id)
        ->first();

        return $data;
    }

    public static function ProductBej(){

        $data = DB::connection('pgsql2')->table('master_products')
        ->select("master_products.product_name","master_products.id")
        ->join('lendings', 'lendings.product_id', '=', 'master_products.id')
        ->join('payment_schedules', 'payment_schedules.lending_id', '=', 'lendings.id')
        // ->where('fully_paid','=',false)
        ->groupBy('master_products.product_name')
        ->groupBy('master_products.id');

        return $data;
    }

    public static function ProductCheckOutstading($id){

        $data = DB::connection('pgsql2')->table('master_products')
        ->select(DB::raw("sum(CAST(payment_schedules.principal as int)) as total"),"master_products.product_name","master_products.id")
        ->join('lendings', 'lendings.product_id', '=', 'master_products.id')
        ->join('payment_schedules', 'payment_schedules.lending_id', '=', 'lendings.id')
        ->where('fully_paid','=',true)
        ->where('master_products.id','=',$id)
        ->groupBy('master_products.product_name')
        ->groupBy('master_products.id')->first();

        return $data;
    }

    public static function Checktotalpayment($id){

        $data = DB::connection('pgsql2')->table('master_products')
        ->select(DB::raw("sum(CAST(payment_schedules.principal as int)) as total"),"master_products.product_name","master_products.id")
        ->join('lendings', 'lendings.product_id', '=', 'master_products.id')
        ->join('payment_schedules', 'payment_schedules.lending_id', '=', 'lendings.id')
        ->where('fully_paid','=',false)
        ->where('master_products.id','=',$id)
        ->groupBy('master_products.product_name')
        ->groupBy('master_products.id')->first();

        return $data;
    }

    public function master_product_interests()
    {
        return $this->hasMany(MasterProductInterest::class, 'id', 'product_id');
    }

    public function master_product_interest_item()
    {
        return $this->hasMany(MasterProductInterestItem::class, 'product_id', 'id');
    }

}
