<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Lender;



class CifController extends Controller
{
    public function index()
    {
        $users = Lender::all();
        return view('backend.pages.users.index', compact('users'));
    }

}
