
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
                    <li><span>Pinjaman</span></li>
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
                    <h4 class="header-title float-left">Lending List</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="tabeluser" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th >Nama</th>
                                    <th >Kode Peminjaman</th>
                                    <th >Nominal Pinjam</th>
                                    <th >Konfirmasi HRD</th>
                                    <th>Action</th>
                                    {{-- <th width="15%">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
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
          <button type="button" class="close" data-dismiss="modal" onclick="close_table();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
        <div class="container" id='img_target_invoice'>
        </div>
        <br>
        <form method="POST" id='confirm'>
            {{-- @method('POST') --}}
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="name">Nama Peminjam</label>
                    <input type="text" class="form-control text-center" id="update_name" name="name" placeholder="Nama Peminjam"  readonly>
                    <input type="hidden" class="form-control text-center" id="update_id" name="id" >

                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="email">Loan Code</label>
                    <input type="text" class="form-control text-center" id="update_loan_code" name="Loan Code" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password">Nominal Pinjaman</label>
                    <input type="tenor" class="form-control text-center" id="update_received_amount" placeholder="Nominal Pinjam" readonly >
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password_confirmation">Status KYC</label>
                    <input type="text" class="form-control text-center" id="update_kyc_status" name="password_confirmation" placeholder="Status KYC" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Nama Product</label>
                    <input type="text" class="form-control text-center" id="update_product_name" name="username" placeholder="Nama Product" readonly >
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Kode Product</label>
                    <input type="text" class="form-control text-center" id="update_product_code" name="username" placeholder="Kode Product" readonly >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Tenor</label>
                    <input type="text" class="form-control text-center" id="update_tenor" name="username" placeholder="Sisa Plafon" readonly >
                 </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Bunga</label>
                    <input type="text" class="form-control text-center" id="update_bunga" name="username" placeholder="Sisa Plafon" readonly >
                 </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Status Konfirmasi</label>
                    <input type="text" class="form-control text-center" id="update_status" name="username" placeholder="Sisa Plafon" readonly >
                 </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Tanggal Peminjaman</label>
                    <input type="text" class="form-control text-center" id="update_created_at" name="username" placeholder="Sisa Plafon" readonly >
                 </div>
            </div>

        </form>
        </div>
        <div class="modal-footer float-left">
          <button type="button" id="confirms" class="btn btn-primary shows ">Terima</button>
          <button type="button" id="reject" class="btn btn-danger btns shows">Tolak</button>
        </div>
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

        $(document).ready(function() {

            $('#confirms').click(function(){
                $('#confirm').attr('action', '{{ route('admin.confirms') }}');
                // form.submit();
                $( "#confirm" ).submit();

            });

            $('#reject').click(function(){
                $('#confirm').attr('action', '{{ route('admin.reject') }}');
                $( "#confirm" ).submit();
            });
        });

        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

        var url="{{ route('admin.list_lending_json') }}";

        table =$("#tabeluser").DataTable({
            "responsive": true,
            "autoWidth": false,
            "bPaginate":true,
            "bInfo" : false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'loan_code', name: 'loan_code'},
                {data: 'received_amount', name: 'received_amount'},
                {data: 'status', name:'status'},
                {data: 'btn', name: 'btn', orderable: false, searchable: false},
            ],
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "render": function ( data, type, row ) {
                    return "<a class=\"btn btn-xs btn-outline-info\" data-toggle=\"modal\" title=\"View\" onclick=\"showData("+data+")\" data-target=\"#modalBorrowers\">Konfirmasi Pinjaman</a>";
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
                "url": url,
                "type": "GET"
            },
    
        });

        function showData(id){

            $('.modal-title').text('');
            $("#modal_form").modal('show');
            var isurl="{{ route('admin.getLending') }}";

            $.ajax({
                url :isurl,
                type : 'post',
                data: { "_token": "{{ csrf_token() }}","lending_id":id},
                success : function(data){

                    var obj = JSON.parse(data);

                    $(".shows").show();
                    $('#update_id').val(obj.id);
                    $('#update_name').val(obj.name);
                    $('#update_loan_code').val(obj.loan_code);
                    $('#update_kyc_status').val(obj.kyc_status);
                    $('#update_received_amount').val(obj.received_amount);
                    $('#update_created_at').val(obj.created_at);
                    $('#update_bunga').val(obj.bunga);
                    $('#update_tenor').val(obj.tenor);
                    $('#update_product_code').val(obj.product_code);
                    $('#update_product_name').val(obj.product_name);
                    $('#update_status').val(obj.status);
                    
                    if(obj.status == 'confirmed' || obj.status == 'rejected'){
                        $(".shows").hide();
                    }

                    // $('#update_kyc_status').val(obj.kyc_status);


                }
            })

        }

        // function confirm(){
        //     $('.modal-title').text('Akses Pinjaman');
        //     $("#modal_form").modal('show');
        // }

     </script>
@endsection