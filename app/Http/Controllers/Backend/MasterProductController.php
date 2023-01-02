<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProduct;
use App\Models\MasterProductInterestItem;
use App\Models\GeneratorAccesLoan;
use App\Models\Company;
use App\Models\MasterProductPenaltyCost;
use App\Models\MasterProductOtherCost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use DataTables;

use function Ramsey\Uuid\v1;

class MasterProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $keyword="https://storage.googleapis.com/klikumkm/upload/images";
        $records = MasterProduct::Productlist();

        $datas = [];
        foreach($records as $record){

            if($record->category == 0){
                $kategori = 'Konsumtif';
            }else{
                $kategori = 'Produktif';
            }

            $row['id']=$record->id;
            $row['status']="Akses Terbatas";
            $row['product_code']=$record->product_code;
            $row['category'] = $kategori;
            $row['product_name']=$record->product_name;
            $row['total_payment']=$this->rupiah($record->min_amount).'/'.$this->rupiah($record->max_amount);

            $datas[]=$row;
        }

        return view('backend.pages.products.index', compact('datas'));

    }
    public function ProductInterestItems(Request $request){

        $data = MasterProductInterestItem::getDataItem((int)$request->id);
        $datas=null;

        foreach ($data as $rows => $row) {

            if($row->tenor_unit == 'monthly'){
                $satuan=" Bulan";
            }elseif($row->tenor_unit == 'weekly'){
                $satuan=" Minggu";
            }else{
                $satuan=" Hari";
            }

            $datas[$rows]= array("id"=>$row->id,"tenor"=>$row->tenor.$satuan,'interest_rate_calculation'=>$row->interest_rate_calculation,'btn'=>$row->id_master,'interest_rate'=>$row->interest_rate.'% /'.$row->interest_rate_calculation,'product_name'=>$row->product_name,'status'=>"Akses Terbatas");
        }

        return Datatables::of($datas)->make(true);
    }

    public function simulasi(Request $request){

        $products = MasterProductInterestItem::find($request->id);

        if($products->tenor_unit == 'daily'){

            $i=1;
            $nominal_pinjam = 10000000;
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
            $nominal_pinjam = 10000000;
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

    public function show(int $id)
    {
        $products = MasterProduct::find($id);
        $penalty = MasterProductPenaltyCost::where('product_id','=',$products->id)->get();
        $cost = MasterProductOtherCost::where('product_id','=',$products->id)->get();
        $interest_ = MasterProductInterestItem::where('product_id','=',$products->id)->get();


        $data = MasterProduct::Productlist_id($id);

        if($data->tenor_unit == 'monthly'){
            $satuan=" Bulan";
        }elseif($data->tenor_unit == 'weekly'){
            $satuan=" Minggu";
        }else{
            $satuan=" Hari";
        }

        if($satuan == ' Hari'){

            $interest=$data->interest_rate.'%/'.$satuan;
        }else{

            $interest=ceil($data->interest_rate / $data->tenor).'%/'.$satuan;
        }

        $kategori = "Productif";
        if($data->category == 2){
            $kategori = "Konsumtif";
        }

        $penaltys = [];
        if(!empty($penalty)){
            foreach($penalty as $rows=>$row){
                $category = 'Harian';
                if($row->category == 'once'){
                    $category = 'Sekali Bayar';
                }
                $penaltys[$rows] = array('value'=>$row->value,'kategori'=>$category);
            }
        }

        $costs = [];
        if(!empty($cost)){
            foreach($cost as $rows=>$row){
                $type = 'Persentase';
                $nilai = $row->value.' % Dari Nilai Pinjaman';
                if($row->type == 2){
                    $type = 'Rupiah';
                    $nilai = $this->rupiah($row->value);
                }
                $costs[$rows] = array('value'=>$nilai,'type'=>$type,'cost_name'=>$row->cost_name);
            }
        }


        $interests = [];
        if(!empty($interest_)){
            foreach($interest_ as $rows=>$row){
                $type = 'Harian';
                $nilai = $row->value.' % Dari Nilai Pinjaman';
                if($row->tenor_unit == "monthly"){
                    $type = 'Bulan';
                    $nilai = $this->rupiah($row->value);

                }
                $interests[$rows] = array('tenor'=>$row->tenor,'interest_rate'=>$row->interest_rate);
            }
        }

        // dd($interests);
        // exit();

        $products['id']=$data->id;
        $products['denda']='';

        $products['product_code']=$data->product_code;
        $products['category']=$kategori;
        $products['description']=$data->description;
        $products['product_name']=$data->product_name;
        $products['tenor']=$data->tenor.$satuan;
        $products['purpose']=$data->purpose;
        $products['interest_rate']=$interest;


        $products['total_payment']=$this->rupiah($data->min_amount).'/'.$this->rupiah($data->max_amount);
        
        $roles  = Role::all();
        return view('backend.pages.products.show', compact('products', 'roles','penaltys','costs','interests'));
    }

    public function generate(Request $request)
    {

        $code = rand();
        $masterproduct=MasterProduct::find($request->product_id);
        $tenor=MasterProductInterestItem::find($request->product_interest_code);

        $cekAktif=GeneratorAccesLoan::where('user_id', $request->id_user)->where('status','Aktif')->where('product_code',$masterproduct->product_code)->get();

        if(count($cekAktif) != 0){
            $this->Checkcode($request->id_user);
        }

        $save  = array(
            'id'=>GeneratorAccesLoan::getNextId(),
            'product_code' => $masterproduct->product_code,
            'product_id' => $masterproduct->id,
            'created_by' =>Auth::guard('admin')->user()->id,
            'status' => 'Aktif',
            'tenor' => $tenor->tenor,
            'tenor_unit' => $tenor->tenor_unit,
            'product_interest_item_id' =>$request->product_interest_code,
            'acces_code'=>$code,
            'update_at'=>date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'user_id'=>$request->id_user   
        );

        $result = GeneratorAccesLoan::create($save);

        echo json_encode($code,true);    
        exit();
    }
    public function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
    public  function Checkcode($id){
        
        $Code=GeneratorAccesLoan::where('user_id', $id)->update(['status' => "Non Aktif"]);
    }
}
