
@extends('backend.layouts.master')

@section('title')
{{-- Admins - Admin Panel --}}
@endsection

@section('styles')
    <!-- Start datatable css -->
    <style>
        @media screen and (min-width: 676px) {
            .extra {
              max-width: 1000px; /* New width for default modal */
        }
        }
        .text_mini{
          font-size: 10 px;
        }
        .card-body{
          max-height: calc(100vh - 200px);
          overflow-y: auto;
        }
        div.dataTables_wrapper {
              width: 1700px;
              margin: 0 auto;
          }
      </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Product</span></li>
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
                    <h4 class="header-title float-left">Product List</h4>
                    <p class="float-right mb-2">
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Kode Product</th>
                                    <th width="10%">Nama Product</th>
                                    <th width="10%">Tenor Pinjaman</th>
                                    <th width="40%">Bunga</th>
                                    <th width="40%">Jumlah Pinjaman</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{ dd($datas) }} --}}
                                {{-- {{ dd(count($datas)) }} --}}
                                {{-- @if (count($datas) >= 0) --}}

                                    
                               @foreach ($datas as $datasa=>$data)
                               <tr>  
                                    <td>{{ $loop->index+1 }}</td>

                                    <td>{{ $data['product_code']}}</td>
                                    <td>{{ $data['product_name']}}</td>
                                    <td>{{ $data['tenor']}}</td>
                                    <td>{{ $data['interest_rate']}}</td>
                                    <td>{{ $data['total_payment']}}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('product.show'))
                                            <a class="btn btn-info btn-lg text-white" href="{{ route('admin.products.show', $data['id']) }}">Detail</a>
                                        @endif

                                        <a type="button" class="btn btn-info btn-lg" data-toggle="modal" onclick="option_interest({{ $data['id']}})" data-target="#modalInterest">Akses Pinjaman</a>
                                        
                                    </td>
                                </tr>
                               @endforeach
                               {{-- @endif --}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>

<div class="modal fade " id="modalBorrowers" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
  
        <div class="modal-header">
          <h3 class="modal-title">Person Form</h3>
          <button type="button" class="close" data-dismiss="modal" onclick="closes();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
        <div class="container" id='img_target_invoice'>
        </div>
        <br>
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden"  id="product_interest_code"/> 
            <div class="card-body ">
            <table id="tabeluser" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th>Nama Peminjam</th>
                        <th>Status</th>
                        <th>Akses kode</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
  
            </div>
          </form>
        </div>
        <!-- <div class="modal-footer text-center">
          <button type="button" id="btnSave" onclick="confirm_send('Terima')" class="btn btn-primary btns ">Terima</button>
          <button type="button" class="btn btn-danger btns" onclick="confirm_send('Tolak')">Tolak</button>
        </div> -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="modal fade " id="modalInterest" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
  
        <div class="modal-header">
          <h3 class="modal-title">Person Form</h3>
          <button type="button" class="close" data-dismiss="modal" onclick="closes();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
        <div class="container" id='img_target_invoice'>
        </div>
        <br>
          <form action="#" id="" class="form-horizontal">
            <input type="hidden"  id="product_code"/> 
            <div class="card-body ">
            <table id="tabelinterest" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr class="bg-info">
                        <th>product_name</th>
                        <th>tenor</th>
                        <th>interest_rate_calculation</th>
                        <th>interest_rate</th>
                        <th>id</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
  
            </div>
          </form>
        </div>
        <!-- <div class="modal-footer text-center">
          <button type="button" id="btnSave" onclick="confirm_send('Terima')" class="btn btn-primary btns ">Terima</button>
          <button type="button" class="btn btn-danger btns" onclick="confirm_send('Tolak')">Tolak</button>
        </div> -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



  <div class="modal fade " id="showgenerate" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
        <div class="modal-header">
          <h3 class="modal-title">Person Form</h3>
          <button type="button" class="close" data-dismiss="modal" onclick="close_table();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
                Kode Akses <p id="text_target"></p>
        </div>
        <!-- <div class="modal-footer text-center">
          <button type="button" id="btnSave" onclick="confirm_send('Terima')" class="btn btn-primary btns ">Terima</button>
          <button type="button" class="btn btn-danger btns" onclick="confirm_send('Tolak')">Tolak</button>
        </div> -->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

@endsection





@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
     
     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

        function generate(id){

            var product_id=$('#product_code').val();
            var product_interest_code=$('#product_interest_code').val();
            var isurl="{{ route('admin.generate') }}";

            $.ajax({
                url :isurl,
                type : 'post',
                data: { "_token": "{{ csrf_token() }}","product_id":product_id,"id_user":id,"product_interest_code":product_interest_code},
                success : function(data){
                    // alert(data);
                    $('#text_target').text(data);
                    $("#modalBorrowers").modal('hide');
                    $("#showgenerate").modal('show');
                }
            })
        }

        function closes(){
            setTimeout(function(){
          window.location.reload(1);
        }, 1000);
        }

        //pilih interest product id
        function option_interest(id){

            $('#product_code').val('');
            $('.modal-title').text('Pilih Interest Product');
            $('#product_code').val(id);

            var urls="{{route('admin.ProductInterestItems')}}";
            var isid=id;
            
            var table =$("#tabelinterest").DataTable({
            "responsive": true,
            "autoWidth": false,
            "bPaginate":true,
            "bInfo" : false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "columns": [
                {data: 'product_name', name: 'product_name'},
                {data: 'tenor', name: 'tenor'},
                {data: 'interest_rate_calculation', name: 'interest_rate_calculation'},
                {data: 'interest_rate', name: 'interest_rate'},
                {data: 'id', name: 'id'},
                {data: 'btn', name: 'btn', orderable: false, searchable: false},
                
            ],
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "render": function ( data, type, row ) {
                    return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"confirm("+row.id+")\" data-target=\"#modalBorrowers\">Tambah Akses</a>";
                },
                "orderable": false, //set not orderable
                },
            ],
            "order": [], //Initial no order.
            retrieve: true,
            "language": {
            "sEmptyTable": "Data menu Belum Ada"
            },
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": urls,
                    "type": "POST",
                    "data":{ "_token": "{{ csrf_token() }}","id":id,"datas":id}
                },

            });

        }

        
        
        function confirm(id){

          // alert(id);
          $("#modal_form").modal('show');

            $('#product_interest_code').val('');
            $('.modal-title').text('Akses Pinjaman');
            
            $("#modal_form").modal('show');
            $("#modalInterest").hide();
            $("#modalBorrowers").modal('show');
            $('#product_interest_code').val(id);

            var url="{{ route('admin.list_borrowers_json_product') }}";
            var isid=id;

            var table =$("#tabeluser").DataTable({
            "responsive": true,
            "autoWidth": false,
            "bPaginate":true,
            "bInfo" : false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'status_access', name: 'status_access'},
                {data: 'acces_code', name: 'acces_code'},
                {data: 'btn', name: 'btn', orderable: false, searchable: false},
            ],
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "render": function ( data, type, row ) {
                    return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"generate("+data+")\">Buat Kode Akses</a>";
                },
                "orderable": false, //set not orderable
                },
            ],
            "order": [], //Initial no order.
            retrieve: true,
            "language": {
            "sEmptyTable": "Data menu Belum Ada"
            },
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                "ajax": {
                    "url": url,
                    "type": "POST",
                    "data":{ "_token": "{{ csrf_token() }}","id":id,"datas":id}
                },

        });

    }

     </script>
@endsection