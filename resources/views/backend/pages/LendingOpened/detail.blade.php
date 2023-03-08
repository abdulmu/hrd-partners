
@extends('backend.layouts.master')

@section('title')
Admin Edit - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection

@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Detail Product</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.admins.index') }}">Product</a></li>
                    <li><span>Detail Product - {{ $data->name }}</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Detail Pendanaan - {{ $data->loan_code }}</h4>
                    @include('backend.layouts.partials.messages')

                    <form >

                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <p class=""><b>Product Info</b></p>
                            </div>    
                        </div>   

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Create Date</label>
                                <input type="text" class="form-control" id="name"  value="{{ $data->created_at }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Nama Debitur</label>
                                <input type="text" class="form-control" value="{{ $data->name }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">No.Handphone</label>
                                <input type="text" class="form-control" id="name"  value="{{ $data->phone_number }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">No.Pinjaman</label>
                                <input type="text" class="form-control" value="{{ $data->loan_code }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Arragement Number</label>
                                <input type="text" class="form-control" id="name"  value="-" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Account Reference</label>
                                <input type="text" class="form-control" value="-" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">NIK</label>
                                <input type="text" class="form-control" id="name"  value="{{ $data->nik }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Unit</label>
                                <input type="text" class="form-control"  placeholder="Enter Email" value="-" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Nama Bank</label>
                                <input type="text" class="form-control" id="name"  value="-" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Nomor Rekening Debitur</label>
                                <input type="text" class="form-control" value="{{ $data->bank_account_number }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="name">Nama Akun Bank</label>
                                <input type="text" class="form-control" id="name"  value="{{ $data->bank_account_name }}" readonly>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="email">Periode/Tenor</label>
                                <input type="text" class="form-control" value="{{ $data->product_name }}" readonly>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="email">Satuan</label>
                                <input type="text" class="form-control" id="email"  value="{{ $data->product_name }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Nominal Pinjam</label>
                                <input type="text" class="form-control" id="name"  value="{{ $data->loan_amount }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Tanggal Pencairan</label>
                                <input type="text" class="form-control" value="{{ $data->disbursed_at }}" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Nominal Dicairkan</label>
                                <input type="text" class="form-control" id="name"  value="{{ $data->disbursed_amount }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Jenis Product</label>
                                <input type="text" class="form-control" value="{{ $data->product_name }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Batch</label>
                                <input type="text" class="form-control" id="name"  value="-" readonly>
                            </div>
                        </div>

                    </form>
                       <a href="{{ route('admin.products.index') }}"> <button   class="btn btn-primary mt-4 pr-4 pl-4">kembali</button></a>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection