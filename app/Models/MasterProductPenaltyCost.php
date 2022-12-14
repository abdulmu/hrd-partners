<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MasterProductPenaltyCost extends Model
{
    use HasFactory;
    

    protected $table = 'master_product_penalty_cost';
    public $connection = 'pgsql2';


    protected $fillable = [
        'id',
        'product_id',
        'rule_condition',
        'category',
        'value',
        'penalty_cost',
        'min',
        'max',
        'type',
        'penalty_late_tolerance',
    ];

    public function master_products()
    {
        return $this->hasMany(MasterProduct::class, 'id', 'product_id');
    }

    public function getNextId()
    {
        $lastProduct = DB::table('master_product_penalty_cost')->orderBy('id', 'desc')->limit(1)->first();
        return $lastProduct ? $lastProduct->id + 1 : 1;
    }
    
}
