<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Lending;
use App\Models\LendingBorrowers;


class LendingPaymentController extends Controller
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

        $rawData = LendingBorrowers::lendingPaymentSchedule();
        if ($raw) {
            $datas = json_encode($rawData->get());
        } else {
            $datas =json_encode($rawData->paginate(10, ['*'], 'page', $page));
        }

        $data1 = json_decode($datas, true);
        $pages['data']=$data1['data'];
        $pagination = LendingBorrowers::lendingPaymentSchedule()->paginate(10);

        // var_dump($pagination);
        // exit();
        return view('backend.pages.lendingPayment.index',compact('pages','pagination'));
    }

    public function show(int $id)
    {
        $data = LendingBorrowers::lendingFundingParameters($id);
        return view('backend.pages.lendingPayment.detail',compact('data'));
    }   
}
