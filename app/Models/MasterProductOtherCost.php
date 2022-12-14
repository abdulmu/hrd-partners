<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MasterProductOtherCost extends Model
{
    use HasFactory;

    protected $table = 'master_product_other_cost';
    public $connection = 'pgsql2';

    protected $fillable = [
        'id',
        'product_id',
        'cost_code',
        'cost_name',
        'rule_condition',
        'type',
        'value',
        'min',
        'max',
        'frequency'
    ];

    public function getNextId()
    {
        $lastProduct = DB::table('master_product_other_cost')->orderBy('id', 'desc')->limit(1)->first();
        return $lastProduct ? $lastProduct->id + 1 : 1;
    }

    public function master_products()
    {
        return $this->hasMany(MasterProduct::class, 'id', 'product_id');
    }

}
