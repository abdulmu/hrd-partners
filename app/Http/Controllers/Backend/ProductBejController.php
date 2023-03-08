<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterProduct;


class ProductBejController extends Controller
{
    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $raw = (bool) $request->query('raw') ?? false;
        $rawData = MasterProduct::ProductBej();

        if ($raw) {
            $datas = json_encode($rawData->get());
        } else {
            $datas =json_encode($rawData->paginate(10, ['*'], 'page', $page));
        }

        $data1 = json_decode($datas, true);

        $record=null;
        foreach($data1['data'] as $rows=>$row){

            $totalBayarquery = MasterProduct::ProductCheckOutstading($row['id']);
            $totalBayar=0;
            if($totalBayarquery != null){
                $totalBayar=$totalBayarquery->total;
            }

            $OutStandingquery = MasterProduct::Checktotalpayment($row['id']);
            $OutStanding=0;
            if($OutStandingquery != null){
                $OutStanding=$OutStandingquery->total;
            }

            $record[$rows]=array("product_name"=>$row['product_name'],'id'=>$row['id'],'outstading'=>$OutStanding,'totalbayar'=>$totalBayar);
        }

        // $data1 = json_decode($datas, true);
        $pages['data']=$record;
        // var_dump($records);
        // exit();
        $pagination = MasterProduct::ProductBej()->paginate(10);

        return view('backend.pages.productBej.index',compact('pages','pagination'));
    }

}
