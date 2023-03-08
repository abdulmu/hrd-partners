
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
                    <li><span>Peminjam</span></li>
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
                    <h4 class="header-title float-left">Borrowers List</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="tabeluser" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th >Nama</th>
                                    <th >Email</th>
                                    <th >Status KYC</th>
                                    <th >No Tlpn</th>
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
        <form  method="POST" name="borrowers_form">

            @method('PUT')
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="name">Nama Peminjam</label>
                    <input type="text" class="form-control text-center" id="update_name" name="name" placeholder="Enter Name" >
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="email">No Tlpn</label>
                    <input type="text" class="form-control text-center" id="update_phone_number" name="email" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password">Email</label>
                    <input type="tenor" class="form-control text-center" id="update_email" name="email" >
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password_confirmation">Status KYC</label>
                    <input type="text" class="form-control text-center" id="update_kyc_status" name="password_confirmation">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Pendapatan Bulanan</label>
                    <input type="text" class="form-control text-center" id="update_monthly_income" name="monthly_income" placeholder="Pendapatan Bulanan" required >
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Plafon Pinjaman</label>
                    <input type="text" class="form-control" id="update_plafon" name="plafon" placeholder="Plafon Pinjaman" required >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                   <label for="username">Plafon Aktif</label>
                   <input type="text" class="form-control text-center" id="update_plafon_active" name="update_palfon_active" placeholder="Enter Username" required >
               </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Sisa Plafon</label>
                    <input type="text" class="form-control"  id="update_plafon_use" name="plafon_use" placeholder="Sisa Plafon" required >
                 </div>
            </div>

        </div>
        <div class="modal-footer float-left">
          <button type="submit" id="btnSave"  class="btn btn-primary ">Terima</button>
          <button type="button" class="btn btn-danger btns" onclick="confirm_send('Tolak')">Cancel</button>
        </div>
    </form>

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

        var url="{{ route('admin.list_borrowers_json') }}";

        table =$("#tabeluser").DataTable({
            "responsive": true,
            "autoWidth": false,
            "bPaginate":true,
            "bInfo" : false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'kyc_status', name: 'kyc_status'},
                {data: 'phone_number', name:'phone_number'},
                {data: 'btn', name: 'btn', orderable: false, searchable: false},
            ],
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "render": function ( data, type, row ) {
                    return "<a class=\"btn btn-xs btn-outline-info\" data-toggle=\"modal\" title=\"View\" onclick=\"showData("+data+")\" data-target=\"#modalBorrowers\">Detail</a>";
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
                //Set column definition initialisation properties.
                // "columnDefs": [
                // { 
                //     "targets": [ -1 ], //last column
                //     "render": function ( data, type, row ) {

                //         if (row[4]=="N") { 
                //         return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"vmenu("+row[7]+")\"><i class=\"fas fa-eye\"></i>"
                //         }else{
                //         return "<a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"View\" onclick=\"generate("+row[3]+")\">Buat Kode Akses</a> <a class=\"btn btn-xs btn-outline-warning\" href=\"javascript:void(0)\" title=\"View\" onclick=\"non_active("+row[3]+")\">Non Aktif Akun</a>";
                //     }

                //     },
                //     "orderable": false, //set not orderable
                //     },
                //     ],
                // }
        });

        function showData(id){

            // alert(id);

            $('.modal-title').text('');
            $("#modal_form").modal('show');

            var isurl="{{ route('admin.getBorrower') }}";

            $.ajax({
                url :isurl,
                type : 'post',
                data: { "_token": "{{ csrf_token() }}","id_user":id},
                success : function(data){

                    var obj = JSON.parse(data);
                    // alert(data);
                    // setTimeout(function(){
                    // window.location.reload(1);
                    // }, 1000);
                    $('#update_id').val(obj.id);
                    $('#update_monthly_income').val(obj.monthly_income);
                    $('#update_plafon').val(obj.plafon);
                    $('#update_plafon_active').val(obj.plafon_active);
                    $('#update_name').val(obj.name);
                    $('#update_phone_number').val(obj.phone_number);
                    $('#update_plafon_use').val(obj.plafon_use);
                    $('#update_email').val(obj.email);
                    $('#update_plafon').val(obj.plafon);
                    $('#update_kyc_status').val(obj.kyc_status);

                    var url="{{ route('admin.borrowers.update',"") }}"+'/'+obj.id;
                    // alert(url);
                    document.borrowers_form.action = url;

                }
            })

        }

        // function confirm(){
        //     $('.modal-title').text('Akses Pinjaman');
        //     $("#modal_form").modal('show');
        // }

        $(document).ready(function() {

            $('#update_monthly_income').on('input',function(e){
                // var vss =plafon_active.replace(/[^0-9]/g, '');
                var pendapatan = $('#update_monthly_income').val().replace(/[^0-9]/g, '') / 3;
                var plafon=Math.ceil(pendapatan); //plafon

                $('#update_plafon').val(plafon);
                var plafon_active= $('#update_plafon_active').val(); //palfon aktif
                var vss =plafon_active.replace(/[^0-9]/g, '');
                var update_reminder_active =  Math.ceil(plafon - vss);
                $('#update_plafon_use').val(update_reminder_active);

            });
        });

        function formatMoney(number, decPlaces, decSep, thouSep) {

            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSep = typeof decSep === "undefined" ? "." : decSep;
            thouSep = typeof thouSep === "undefined" ? "," : thouSep;
            var sign = number < 0 ? "-" : "";
            var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
            var j = (j = i.length) > 3 ? j % 3 : 0;

            return sign +
                (j ? i.substr(0, j) + thouSep : "") +
                i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
                (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
        }
     </script>
@endsection