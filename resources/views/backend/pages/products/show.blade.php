
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
                    <li><span>Detail Product - {{ $products->name }}</span></li>
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
                    <h4 class="header-title">Detail Product - {{ $products->product_name }}</h4>
                    @include('backend.layouts.partials.messages')

                    <form >

                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <p class=""><b>Product Info</b></p>
                            </div>    
                        </div>   

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Nama Product</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $products->product_name }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Kode Product</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $products->product_code }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Jumlah Pinjaman</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $products->total_payment }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Kategori Pinjaman</label>
                                <input type="text" class="form-control" id="username" name="category" placeholder="Enter Username" required value="{{ $products->category }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <label for="username">Deskripsi Produk</label>
                                <textarea class="form-control textarea-autosize" id="floating-icon" rows="1" readonly>{{ $products->description }}</textarea>                           
                             </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <p class=""><b>Tenor & Bunga</b></p>
                            </div>    
                        </div>   

                        <div class="form-row">

                            @foreach ($interests as $datasa=>$data)
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Denda Keterlambatan</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $data['tenor']}}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Satuan</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $data['interest_rate'] }}" readonly>
                            </div>
                        @endforeach
                            {{-- <div class="form-group col-md-6 col-sm-12">
                                <label for="password">tenor</label>
                                <input type="tenor" class="form-control" id="tenor" name="tenor" value="{{ $products->tenor }}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password_confirmation">Bunga</label>
                                <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ $products->interest_rate }}" readonly>
                            </div> --}}
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <p class=""><b>Denda</b></p>
                            </div>    
                        </div>   
                        <div class="form-row">

                            {{-- {{ dd($penaltys ) }} --}}
                            {{-- <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Denda Keterlambatan</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $products->denda }}" readonly>
                            </div>

                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Denda Keterlambatan</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $products->cost }}" readonly>
                            </div> --}}
                            @foreach ($penaltys as $datasa=>$data)
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="username">Denda Keterlambatan</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $data['value']}}" readonly>
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <label for="username">Satuan</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $data['kategori'] }}" readonly>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 col-sm-12">
                                <p class=""><b>Biaya Tambahan</b></p>
                            </div>    
                        </div>   
                        <div class="form-row">
                            @foreach ($costs as $datasa=>$data)
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Biaya {{ $data['cost_name']}} </label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $data['value']}}" readonly>
                            </div>
                            <div class="form-group col-md-6 col-sm-6">
                                <label for="username">Satuan</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required value="{{ $data['type'] }}" readonly>
                            </div>
                        @endforeach
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