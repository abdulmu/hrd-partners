
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
                                    <th width="20%">Kategori Pinjaman</th>
                                    <th width="30%">Status</th>
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
                                    <td>{{ $data['category']}}</td>
                                    <td>{{ $data['status']}}</td>
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
                        <th>Phone Number</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
  
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="modal fade " id="modalSimulasi" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
  
        <div class="modal-header">
          <h3 class="modal-title">Person Form</h3>
          <button type="button" class="close"  onclick="close_simulasi();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
        <div class="container" id='img_target_invoice'>
        </div>
        <br>

        <input type="text" class="form-control" id='nominal' readonly>
        <input type="text" class="form-control" id='periode_pinjam' readonly>

        <table class='table'>
          <thead>
            <tr>
                <td>No</td>
                <td>Total Angsuran</td>
                <td>Pokok Pinjaman</td>
                <td>Bunga</td>
                <td>Tanggal Bayar</td>
            </tr>
          </thead>
            <tbody id='tabl'>
          </tbody>
        </table>

        </div>
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
                        <th>Nama Produk</th>
                        <th>Tenor Pinjaman</th>
                        {{-- <th>Bunga</th> --}}
                        <th>Bunga</th>
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
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



  <div class="modal fade " id="showgenerate" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
        <div class="modal-header">
          <h3 class="modal-title">Person Form</h3>
          <button type="button" class="close" data-dismiss="modal" onclick="closes();" >
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
                // {data: 'interest_rate_calculation', name: 'interest_rate_calculation'},
                {data: 'interest_rate', name: 'interest_rate'},
                {data: 'id', name: 'id'},
                {data: 'btn', name: 'btn', orderable: false, searchable: false},
                
            ],
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "render": function ( data, type, row ) {
                    return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"confirm("+row.id+")\" data-target=\"#modalBorrowers\">Tambah Akses</a> <a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"simulasi_pinjam("+row.id+")\" data-target=\"#modalBorrowers\">Simulasi Pinjaman</a>";
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

        function simulasi_pinjam(id){

          // alert(id);
          $('#modalInterest').hide();
          $("#modalSimulasi").modal('show');
          $('.modal-title').text('Simulasi Pinjaman');
          var urls="{{route('admin.simulasi')}}";

          $.ajax({
          url : urls,
          type: "POST",
          dataType: "JSON",
          data: { "_token": "{{ csrf_token() }}","id":id},
          success: function(data)
          {
            console.log(data);
            $('#tabl').html('');
            let hitung= 0;
            $.each(data, function(i, item) {
            hitung ++;
            var numbers=item.tenors ^ 0;
            console.log(numbers);
            // alert(item.tenors);
            if(hitung === 1){
              $('#tabl').append('<tr><td>'+hitung+'</td><td>'+item.angsuran+'</td><td>'+item.pokok+'</td><td>'+item.bunga_per_bulan+'</td><td>'+item.tanggal_bayar+'</td></tr>');

                var tanggal= "<?php echo date('d-m-Y')?>";
                if(item.type == 'harian'){
                  $('#nominal').val('Nominal Peminjaman: '+item.nominal_pinjaman +' Dengan Bunga '+item.persentase_bunga +'%/Hari');
                }else{
                  $('#nominal').val('Nominal Peminjaman: '+item.nominal_pinjaman +' Dengan Bunga '+item.persentase_bunga +'%/Bulan');
                }
                $('#periode_pinjam').val('Tenor: '+item.tenor +' Dengan Tanggal Simulasi Pencairan ' + tanggal);
                $('#total_bayar').val('Total Pembayaran: '+item.total_bayar);
            }else if(hitung > numbers ){

            }else{
              $('#tabl').append('<tr><td>'+hitung+'</td><td>'+item.angsuran+'</td><td>'+item.pokok+'</td><td>'+item.bunga_per_bulan+'</td><td>'+item.tanggal_bayar+'</td></tr>');
            }

          });


          }
        });

        }

        function close_simulasi(){
          setTimeout(function(){
            window.location.reload(1);
          }, 1000);
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
                {data: 'phone_number', name: 'phone_number'},
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