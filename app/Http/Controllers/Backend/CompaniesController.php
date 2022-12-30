<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use DataTables;


class CompaniesController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    public function list_json(Request $request)
    {

            $data = Company::all();
            $datas=null;

            return Datatables::of($data)->make(true);
    }  

    public function index()
    {
        
        if (is_null($this->user) || !$this->user->can('admin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any admin !');
        }

        $banks = Bank::all();
        

        return view('backend.pages.companies.index',compact('banks'));
    }

    public function create()
    {
        $companies = Company::list_company();

        // exit();
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $roles  = Role::all();
        return view('backend.pages.admins.create', compact('roles','companies'));
    }


    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('admin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any admin !');
        }

        $status=true;
        if($request->status == 'false'){
            $status=false;
        }
        $automatic_status=true;
        if($request->automatic_status == 'false'){
            $automatic_status=false;
        }

        $companies = new Company();
        $companies->id = Company::getNextId();
        $companies->name = $request->name;
        $companies->email = $request->email;
        $companies->phone_number = $request->phone_number;
        $companies->account_bank_id = $request->account_bank_id;
        $companies->email = $request->email;
        $companies->account_number = $request->account_number;
        $companies->pic = $request->pic;
        $companies->status = $status;
        $companies->automatic_status = $automatic_status;
        $companies->account_name = $request->account_name;
        $companies->updated_at = date('d-m-Y H:i:s');
        $companies->save();


        session()->flash('success', 'Data has been created !!');
        return redirect()->route('admin.companies.index');
    }
    
    public function update(Request $request, int $id)
    {

        // Create New Admin
        $update = Company::find($id);

        $status=true;
        if($request->status == 'false'){
            $status=false;
        }
        $automatic_status=true;
        if($request->automatic_status == 'false'){
            $automatic_status=false;
        }

        $update->name = $request->name;
        $update->email = $request->email;
        $update->phone_number = $request->phone_number;
        $update->account_bank_id = $request->account_bank_id;
        $update->email = $request->email;
        $update->account_number = $request->account_number;
        $update->pic = $request->pic;
        $update->status = $status;
        $update->automatic_status = $automatic_status;
        $update->account_name = $request->account_name;
        $update->updated_at = date('d-m-Y H:i:s');



        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $update->save();

        session()->flash('success', 'Data updated !!');
        return back();
    }


    public function getCompany(Request $request){

        $admin = Company::find($request->id);

        echo json_encode($admin);
        exit();

    }

}
