<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrowers;
use App\Models\UserCore;
use App\Models\GeneratorAccesLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use DataTables;

use function Ramsey\Uuid\v1;

class BorrowersController extends Controller
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
        return view('backend.pages.borrowers.index');
    }  

    public function list_borrowers_json(Request $request)
    {

            $data = Borrowers::getData();
            $datas=null;

            foreach($data as $rows=>$row){

                $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,'kyc_status'=>$row->kyc_status,'phone_number'=>$row->phone_number,'id'=>$row->id,'btn'=>$row->id);
            }

            return Datatables::of($datas)->make(true);
    }  
    public function list_borrowers_json_product(Request $request)
    {

            $data = Borrowers::getBorrowers();
            $datas=null;
            foreach($data as $rows=>$row){

                $cekAktif = null;
                if($row->status == '' || $row->status == 'Aktif'){
                    $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,'id'=>$row->id,'btn'=>$row->id,'acces_code'=>$row->acces_code,'status_access'=>$row->status,'phone_number'=>$row->phone_number);
                }
            }
            return Datatables::of($datas)->make(true);
    }  
    public function list_borrowers_ajax(Request $request)
    {
        $data = Borrowers::getData();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }  

    public function getBorrower(Request $request)
    {

        $data = Borrowers::getDataBorrowers($request->id_user);
        $use_plafon=Borrowers::CheckingPlafon($request->borrowerid); //checking flapon active
        
        $use_plafon1=$data->plafon - $use_plafon->total;
        $record['id']= $data->id;
        $record['name']=$data->name;
        $record['plafon']=$this->rupiah($data->plafon);
        $record['gender']=$data->gender;
        $record['phone_number']=$data->phone_number;
        $record['email']=$data->email;
        $record['kyc_status']=$data->kyc_status;
        $record['monthly_income']=$this->rupiah($data->monthly_income);
        $record['plafon_use']=$this->rupiah($use_plafon1);
        $record['plafon_active']=$this->rupiah($use_plafon->total);

        echo json_encode($record,true);
    }
    public function update(Request $request, int $id)
    {
        $data=$request->email;
        $borrowers = Borrowers::getDataBorrowers($id);
        $borrowers->name = $request->name;
        // $borrowers->gender = $request->gender;
        $borrowers->plafon = $request->plafon;
        $borrowers->email = $request->email;
        $borrowers->kyc_status = $request->kyc_status;

        $databorrowers['monthly_income']=preg_replace("/[^0-9.]/", "",$request->monthly_income);
        $result = UserCore::where('id','=',$borrowers->borrower_id)->update($databorrowers);




        // $borrowers->monthly_income = $request->monthly_income;

        var_dump($result);
        exit();




        $borrowers->save();
    } 
    public function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
}
