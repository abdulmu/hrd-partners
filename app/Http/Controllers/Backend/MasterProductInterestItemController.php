<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MasterProductInterestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class MasterProductInterestItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function show(int $id)
    {

        $interest= MasterProductInterestItem::where('product_id','=',$id)->get();
        $data = MasterProductInterestItem::getDataItem((int)$id);
        $datas=null;

        foreach ($data as $rows => $row) {

            if($row->tenor_unit == 'monthly'){
                $satuan=" Bulan";
            }elseif($row->tenor_unit == 'weekly'){
                $satuan=" Minggu";
            }else{
                $satuan=" Hari";
            }

            $totalPayment=$this->rupiah($row->min_amount).'/'.$this->rupiah($row->max_amount);

            $datas[$rows]= array("id"=>$row->id,"product_id"=>$row->product_id,"tenor"=>$row->tenor.$satuan,'interest_rate_calculation'=>$row->interest_rate_calculation,'btn'=>$row->id_master,'interest_rate'=>$row->interest_rate.'% /'.$row->interest_rate_calculation,'product_name'=>$row->product_name,'product_code'=>$row->product_code,'totalPayment'=>$totalPayment);
        }

        return view('backend.pages.products.interestProduct', compact('datas'));
    }

    public function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
}
