<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Lending;
use App\Models\LendingBorrowers;
use function Ramsey\Uuid\v1;
use App\Helper\Formating;
use DataTables;


class LendingFundingController extends Controller
{
    private $model;
    private $title = 'Lending Pendanaan';

    public function __construct(Lending $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {

        $page = $request->query('page') ?? 1;
        $raw = (bool) $request->query('raw') ?? false;

        $rawData = LendingBorrowers::lendingFunding();
        if ($raw) {
            $datas = json_encode($rawData->get());
        } else {
            $datas =json_encode($rawData->paginate(10, ['*'], 'page', $page));
        }

        $data1 = json_decode($datas, true);
        $pages['data']=$data1['data'];
        $pagination = LendingBorrowers::lendingFunding()->paginate(10);

        return view('backend.pages.lendingOpened.index',compact('pages','pagination'));
    }

    public function list_lending_json(Request $request)
    {
        // $rawData = LendingBorrowers::with('Lending')->get();

        $page = $request->query('page') ?? 1;
        $raw = (bool) $request->query('raw') ?? false;

        $rawData = LendingBorrowers::with('Lending');
        if ($raw) {
            $datas = $rawData->get();
        } else {
            $datas = $rawData->paginate(10, ['*'], 'page', $page);
        }

        return response()->json([
            'success' => true,
            'data' => $datas
        ]);

    }  
    public function show(int $id)
    {
        $data = LendingBorrowers::lendingFundingParameters($id);


        return view('backend.pages.lendingOpened.detail',compact('data'));

        var_dump($rawData);
        exit();
    }   
}
