<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MasterProductInterestItem extends Model
{
    use HasFactory;

    public const INTEREST_RATE_CALCULATION_MONTHLY = 'monthly'; // bulanan
    public const INTEREST_RATE_CALCULATION_WEEKLY = 'weekly'; // mingguan
    public const INTEREST_RATE_CALCULATION_DAILY = 'daily'; // harian
    public const INTEREST_RATE_CALCULATION_YEARLY = 'yearly'; // tahunan
    public const INTEREST_RATE_CALCULATION_DATA = [
        self::INTEREST_RATE_CALCULATION_MONTHLY => 'Bulanan',
        self::INTEREST_RATE_CALCULATION_WEEKLY => 'Mingguan',
        self::INTEREST_RATE_CALCULATION_DAILY => 'Harian',
        self::INTEREST_RATE_CALCULATION_YEARLY => 'Tahunan',
    ];

    protected $fillable = [
        'id',
        'product_interest_id',
        'tenor',
        'tenor_unit',
        'grace_period',
        'interest_rate',
        'interest_rate_calculation',
        'product_id'
    ];
    public $timestamps = false;
    protected $table = 'master_product_interest_items';
    public $connection = 'pgsql2';


    public function master_product()
    {
        return $this->belongsTo(MasterProduct::class, 'product_id', 'id');
    }

    public static function getFilterData($id)
    {
        $data = DB::table('master_products')
        ->select('master_product_interest_items.id','product_name','interest_code','interest_rate','interest_rate_calculation','tenor','tenor_unit','grace_period')
        ->join('master_product_interest', 'master_product_interest.product_id', '=', 'master_products.id')
        ->join('master_product_interest_items', 'master_product_interest_items.product_interest_id', '=', 'master_product_interest.id')
        ->where('master_product_interest_items.product_interest_id', $id);

        return $data;
    }

    public function getNextId()
    {
        $lastProduct = DB::table('master_product_interest_items')->orderBy('id', 'desc')->limit(1)->first();
        return $lastProduct ? $lastProduct->id + 1 : 1;
    }

    public static function getDataItem($id)
    {
        $data = DB::connection('pgsql2')->table('master_products')
        ->select('master_product_interest_items.id','product_name','tenor_unit','interest_rate_calculation','interest_rate','tenor','master_products.id as id_master')
        ->join('master_product_interest_items', 'master_product_interest_items.product_id', '=', 'master_products.id')
        ->where('master_products.id', $id)
        ->get();

        return $data;
    }
}
