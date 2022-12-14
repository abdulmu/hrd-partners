<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lending;
use Illuminate\Support\Facades\Auth;
use DataTables;


class LendingController extends Controller
{
    public function index(Request $request)
    {

        return view('backend.pages.lending.index');
    }

    public function list_lending_json()
    {

        $data = Lending::Datalist();
        $datas=null;

        foreach($data as $rows=>$row){

            // if($row->acces_code == null || $row->acces_code == ""){
            //     $access="Tidak Ada Akses";
            // }else{
            //     $access=$row->status_code;

            // }

            $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm' onclick='generate($row->id)'>"."Buat Kode Akses"."</a>";
            $datas[$rows]= array("name"=>$row->name,"loan_code"=>$row->loan_code,"received_amount"=>$row->received_amount,"created_at"=>$row->created_at,'btn'=>$row->id);
        }

        return Datatables::of($datas)
                ->make(true);
    }  
    public function getLending(Request $request)
    {

        $data = Lending::Getlist($request->lending_id);

        $record['id']= $data->id;
        $record['name']=$data->name;
        $record['loan_code']=$data->loan_code;
        $record['created_at']=$data->created_at;
        $record['received_amount']=$this->rupiah($data->received_amount);


        echo json_encode($record,true);
    } 
    public function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    
}
