<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrowers;

class KycController extends Controller
{

    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $raw = (bool) $request->query('raw') ?? false;

        $rawData = Borrowers::kyc();
        if ($raw) {
            $datas = json_encode($rawData->get());
        } else {
            $datas =json_encode($rawData->paginate(10, ['*'], 'page', $page));
        }

        $data1 = json_decode($datas, true);
        $pages['data']=$data1['data'];
        $pagination = Borrowers::kyc()->paginate(10);

        return view('backend.pages.kyc.index',compact('pages','pagination'));
    }
    
}
