<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrowers;
use App\Models\GeneratorAccesLoan;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DataTables;

use function Ramsey\Uuid\v1;

class BorrowersController extends Controller
{
    
    public function index(Request $request)
    {
        return view('backend.pages.borrowers.index');
    }  

    public function list_borrowers_json(Request $request)
    {

            $data = Borrowers::getData();
            $datas=null;

            // var_dump($data);
            // exit();
            foreach($data as $rows=>$row){
                
                // $cekAktif=GeneratorAccesLoan::where('user_id', $row->id)->get();
                // if(count($cekAktif) == 0){
                //     $access="Tidak Ada Akses";
                // }else{
                //     $access=0;
                // }

                $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,'kyc_status'=>$row->kyc_status,'phone_number'=>$row->phone_number,'id'=>$row->id,'btn'=>$row->id);

                // $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm' onclick='generate($row->id)'>"."Buat Kode Akses"."</a>";
                // $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,"gender"=>$row->gender,"status_access"=>$access,'access_code'=>$row->acces_code,'kyc_status'=>$row->kyc_status,'btn'=>$row->id,'phone_number'=>$row->phone_number,'id'=>$row->id);
            }
            // var_dump($datas);
            // exit();
        // echo json_encode($datas, true);
        // exit();

            return Datatables::of($datas)->make(true);
    }  
    public function list_borrowers_json_product(Request $request)
    {

            $data = Borrowers::getBorrowers();
            $datas=null;

            // var_dump($data);
            // exit();
            foreach($data as $rows=>$row){

            $cekAktif = null;

         
                // var_dump($cekAktif);
                // exit();
                if($cekAktif ==  null){
                    $status="Tidak Ada Akses";
                $access = $row->id;
                }else{
                    var_dump($cekAktif);
                    exit();
                    $access = $row->id;

                    // var_dump($cekAktif);
                    // exit();
                    // $access = $cekAktif;

                    $status=$cekAktif->status;
                }

                $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,'id'=>$row->id,'btn'=>$row->id,'acces_code'=>$row->acces_code,'status_access'=>$row->status);

                // $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,'kyc_status'=>$row->kyc_status,'phone_number'=>$row->phone_number,'id'=>$row->id,'btn'=>$row->id,'acces_code'=>$access,'status_access'=>$status);

                // $btn = "<a href='javascript:void(0)' class='edit btn btn-primary btn-sm' onclick='generate($row->id)'>"."Buat Kode Akses"."</a>";
                // $datas[$rows]= array("name"=>$row->name,"email"=>$row->email,"gender"=>$row->gender,"status_access"=>$access,'access_code'=>$row->acces_code,'kyc_status'=>$row->kyc_status,'btn'=>$row->id,'phone_number'=>$row->phone_number,'id'=>$row->id);
            }
            // var_dump($datas);
            // exit();
        // echo json_encode($datas, true);
        // exit();

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

        // if (is_null($this->user) || !$this->user->can('admin.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        // }

        // // TODO: You can delete this in your local. This is for heroku publish.
        // // This is only for Super Admin role,
        // // so that no-one could delete or disable it by somehow.
        // if ($id === 1) {
        //     session()->flash('error', 'Sorry !! You are not authorized to update this Admin as this is the Super Admin. Please create new one if you need to test !');
        //     return back();
        // }

        $data=$request->email;


        // // Create New Admin
        $borrowers = Borrowers::getDataBorrowers($id);

        // dd($borrowers);
        // exit();

        // // Validation Data
        // $request->validate([
        //     'name' => 'required|max:50',
        //     'email' => 'required|max:100|email|unique:admins,email,' . $id,
        //     'password' => 'nullable|min:6|confirmed',
        // ]);


        $borrowers->name = $request->name;
        $borrowers->email = $request->email;
        // $admin->username = $request->username;
        // if ($request->password) {
        //     $admin->password = Hash::make($request->password);
        // }
        $borrowers->save();

        // $admin->roles()->detach();
        // if ($request->roles) {
        //     $admin->assignRole($request->roles);
        // }

        // session()->flash('success', 'Admin has been updated !!');
        // return back();
    } 
    public function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
}
