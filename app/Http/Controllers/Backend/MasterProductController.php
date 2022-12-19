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

    public function index(Request $request)
    {
        $keyword="https://storage.googleapis.com/klikumkm/upload/images";
        $records = MasterProduct::Productlist();
        // var_dump($records);
        // exit();

        $datas = [];
        foreach($records as $record){

            // if($record->tenor_unit == 'monthly'){
            //     $satuan=" Bulan";
            // }elseif($record->tenor_unit == 'weekly'){
            //     $satuan=" Minggu";
            // }else{
            //     $satuan=" Hari";
            // }

            // if($satuan == ' Hari'){

            //     $interest=$record->interest_rate.'%/'.$satuan;
            // }else{

            //     $interest=ceil($record->interest_rate / $record->tenor).'%/'.$satuan;
            // }

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
            // $row['tenor']=$record->tenor.$satuan;
            // $row['interest_rate']=$interest;
            $row['total_payment']=$this->rupiah($record->min_amount).'/'.$this->rupiah($record->max_amount);

            $datas[]=$row;
        }

        return view('backend.pages.products.index', compact('datas'));

    }
    public function ProductInterestItems(Request $request){

        $data = MasterProductInterestItem::getDataItem((int)$request->id);

        // dd($data);
        $datas=null;



        foreach ($data as $rows => $row) {

            if($row->tenor_unit == 'monthly'){
                $satuan=" Bulan";
            }elseif($row->tenor_unit == 'weekly'){
                $satuan=" Minggu";
            }else{
                $satuan=" Hari";
            }

            $datas[$rows]= array("id"=>$row->id,"tenor"=>$row->tenor.$satuan,'interest_rate_calculation'=>$row->interest_rate_calculation,'btn'=>$row->id_master,'interest_rate'=>$row->interest_rate,'product_name'=>$row->product_name,'status'=>"Akses Terbatas");
        }

        return Datatables::of($datas)->make(true);
    }

    public function show(int $id)
    {
        $products = MasterProduct::find($id);
        $cost = MasterProductPenaltyCost::where('product_id','=',159)->first();
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

        if($cost->category == 'once'){
            $coststatus=' Sekali Bayar';
        }else{
            $coststatus=' / hari';
        }

        $products['id']=$data->id;
        $products['denda']=$cost->value.$coststatus;
        $products['product_code']=$data->product_code;
        $products['category']=$data->category;
        $products['description']=$data->description;
        $products['product_name']=$data->product_name;
        $products['tenor']=$data->tenor.$satuan;
        $products['purpose']=$data->purpose;
        $products['interest_rate']=$interest;
        $products['total_payment']=$this->rupiah($data->min_amount).'/'.$this->rupiah($data->max_amount);
        
        $roles  = Role::all();
        return view('backend.pages.products.show', compact('products', 'roles'));
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
