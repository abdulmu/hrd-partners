<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lending;
use App\Models\LendingBorrowers;
use App\Models\MasterProductInterestItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use DataTables;

use function Ramsey\Uuid\v1;

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

            $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm' onclick='generate($row->id)'>"."Buat Kode Akses"."</a>";
            $datas[$rows]= array("name"=>$row->name,"loan_code"=>$row->loan_code,"received_amount"=>$this->rupiah($row->loan_amount),"created_at"=>$row->created_at,"status"=>$row->status,'btn'=>$row->id);
        }

        return Datatables::of($datas)->make(true);
    }  

    public function getLending(Request $request)
    {
        $data = Lending::Getlist($request->lending_id);

        if($data->interest_rate_calculation == 'monthly'){
            $interest_rate_calculation = 'Bulan';

        }elseif($data->interest_rate_calculation == 'weekly'){
            $interest_rate_calculation = 'Minggu';

        }elseif($data->interest_rate_calculation == 'daily'){
            $interest_rate_calculation = 'Hari';
        }else{
            $interest_rate_calculation = 'Tahunan';
        }

        if($data->tenor_unit == 'monthly'){
            $tenor_unit = 'Bulan';
        }elseif($data->tenor_unit == 'weekly'){
            $tenor_unit = 'Minggu';
        }elseif($data->tenor_unit == 'daily'){
            $tenor_unit = 'Hari';
        }else{
            $tenor_unit = 'Tahunan';
        }

        $record['id']= $data->id;
        $record['name']=$data->name;
        $record['loan_code']=$data->loan_code;
        $record['interest_rate_calculation']=$data->interest_rate_calculation;
        $record['interest_rate']=$data->interest_rate;
        $record['product_name']=$data->product_name;
        $record['product_code']=$data->product_code;
        $record['status']=$data->status;
        $record['kyc_status']=$data->kyc_status;
        $record['created_at']=$data->created_at;
        $record['bunga'] = $data->interest_rate.'%/'.$interest_rate_calculation;
        $record['tenor'] = $data->tenor.' '.$tenor_unit;

        $record['received_amount']=$this->rupiah($data->loan_amount);

        echo json_encode($record,true);
    }
    public function confirms(Request $request)
    {

        $status = 'confirmed';

        $data['lending_id'] = $request->id;
        $data=json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_URL,'https://p2p.klikumkm.co.id/api/v1/hrds/scoring');
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $hasil=curl_exec($ch);

        $err = curl_error($ch);
        curl_close ($ch);
        $result=json_decode($hasil, true);


        // $table = ['lendings', 'lending_borrowers', 'confirm_hrd'];

        // foreach($table as $row){            
        //     $table = Lending::CofirmUpdate1($request->id,$status,$row);
        // }

        $data = Lending::CofirmUpdate1($request->id,$status);
        session()->flash('success', 'Confirm Success !!');
        return back();
    }   
    
    public function reject(Request $request)
    {
        $status = 'reject_hrd';

        $data['lending_id'] = $request->id;
        $data=json_encode($data);
        $table = ['lendings', 'lending_borrowers', 'confirm_hrd'];

        foreach($table as $row){            
            $table = Lending::CofirmUpdate($request->id,$status,$row);
        }

        session()->flash('success', 'Rejected Success !!');
        return back();
    }   
    public function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }    

    public function simulasi(Request $request){

        $Lending = Lending::Getlist($request->id);
        $products = MasterProductInterestItem::find($Lending->product_interest_item_id);

        if($products->tenor_unit == 'daily'){

            $i=1;
            $nominal_pinjam = (int)$Lending->loan_amount;
            $total_periode=(int)$products->tenor;
            $persentase_bunga = (float)$products->interest_rate;
            $data['interest_rate_calculation'] = $products->interest_rate_calculation;
            $month_sched = date('d-m-Y');
            $pokok = $nominal_pinjam ;
            $bunga = $nominal_pinjam * $persentase_bunga / 100 * $total_periode ;
            $total_bayar = $pokok + $bunga;
            $tambah_hari=" +".$total_periode."day";
            $tanggal = date("d-M-Y",strtotime($month_sched.$tambah_hari));
            $data[$i]=array('bunga'=>$this->rupiah($bunga),'nominal_pinjaman'=>$this->rupiah($nominal_pinjam),'tanggal_bayar'=>$tanggal,'pokok'=>$this->rupiah($pokok),'bunga_per_bulan'=>$this->rupiah($bunga),'angsuran'=>$this->rupiah($total_bayar),'tenor'=>$total_periode.' Hari','total_bayar'=>$this->rupiah($total_bayar),'persentase_bunga'=>$persentase_bunga,'tenors'=>$total_periode);
            
        }else{

            $i=1;
            $nominal_pinjam = (int)$Lending->loan_amount;
            $total_periode=(int)$products->tenor;
            $persentase_bunga = (float)$products->interest_rate;
            $data['interest_rate_calculation'] = $products->interest_rate_calculation;
            $month_sched = date('d-m-Y');
            $pokok = $nominal_pinjam / $total_periode;
            $bunga = $nominal_pinjam * $persentase_bunga / 100 ;
            $total_bayar = $pokok + $bunga;
            while($i <= $total_periode) {
                    
                $tambah_bulan=" +".$i."month";
                $tanggal[$i] = date("d-M-Y",strtotime($month_sched.$tambah_bulan));
                $data[$i]=array('bunga'=>$this->rupiah($bunga),'nominal_pinjaman'=>$this->rupiah($nominal_pinjam),'tanggal_bayar'=>$tanggal[$i],'pokok'=>$this->rupiah($pokok),'bunga_per_bulan'=>$this->rupiah($bunga),'angsuran'=>$this->rupiah($total_bayar),'tenor'=>$total_periode.' Bulan','total_bayar'=>$this->rupiah($total_bayar),'persentase_bunga'=>$persentase_bunga,'tenors'=>$total_periode);
                
                $i++;
            }
        }

        echo json_encode($data,true);
        exit();
    }

}
