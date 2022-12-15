
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
                    <li><span>Perusahaan</span></li>
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
                    <h4 class="header-title float-left">Perusahaan List</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('company.create'))
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahdata">
                            Tambah Perusahaan
                          </button>                          
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="tabeluser" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th >Nama Perusahaan</th>
                                    <th >Phone</th>
                                    <th >Email </th>
                                    <th >PIC</th>
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

<div class="modal fade " id="modalshow" role="dialog">
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
            <form  method="POST" >

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="name">Nama Perusahaan</label>
                        <input type="text" class="form-control text-center edit" id="show_name" name="name"   readonly>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="email">No Tlpn</label>
                        <input type="text" class="form-control text-center edit" id="show_phone_number" name="phone_number"  readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="password">Email</label>
                        <input type="tenor" class="form-control text-center edit" id="show_email" name="email" readonly>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="password_confirmation">Tanggal Pembuatan</label>
                        <input type="date" class="form-control text-center edit" id="updatte_created_at" name="created_at" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="username">Kode Bank</label>
                        <select name="account_bank_id" class="form-control" id="show_account_bank_id" readonly>
                            @foreach($banks as $bank )
                                <option value="{{$bank->id}}" >{{$bank->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="username">Atas Nama Pemilik</label>
                        <input type="text" class="form-control text-center edit" id="show_account_name" name="account_name" readonly >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Nomor Rekening</label>
                    <input type="number" class="form-control text-center edit" id="show_account_number" name="account_number"  readonly >
                </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <label for="username">Perusahaan</label>
                        <input type="text" class="form-control text-center edit"  id="show_pic" name="pic" readonly >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Status</label>
                    <br>
                    <input type="radio"  name="status"  class="edit"  value="true"> Aktif
                    <input type="radio" name="status" class="edit" value="false"> Non Aktif               
                    </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Status Komfirmasi Otomatis</label>
                    <br>
                    <input type="radio" class="edit" name="automatic_status" value="true"> Aktif
                    <input type="radio" class="edit" name="automatic_status" value="false"> Non Aktif  
                </div>

                </div>

            </div>
        </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


<div class="modal fade " id="modalBorrowers" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
  
        <div class="modal-header">
          <h3 class="modal-title">Tambah Data</h3>
          <button type="button" class="close" data-dismiss="modal" onclick="close_table();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
        <div class="container" id='img_target_invoice'>
        </div>
        <br>
        <form  method="POST" name="update_form">

            @method('PUT')
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="name">Nama Perusahaan</label>
                    <input type="text" class="form-control text-center edit" id="update_name" name="name" placeholder="Enter Name" >
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="email">No Tlpn</label>
                    <input type="text" class="form-control text-center edit" id="update_phone_number" name="phone_number" placeholder="Phone Number" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password">Email</label>
                    <input type="tenor" class="form-control text-center edit" id="update_email" name="email" placeholder="Email" >
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password_confirmation">Tanggal Pembuatan</label>
                    <input type="date" class="form-control text-center edit" id="updatte_created_at" name="created_at" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Kode Bank</label>
                    <select name="account_bank_id" class="form-control" id="update_account_bank_id">
                        @foreach($banks as $bank )
                            <option value="{{$bank->id}}" >{{$bank->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Atas Nama Pemilik</label>
                    <input type="text" class="form-control text-center edit" id="update_account_name" name="account_name" placeholder="Atas Nama Pemilik" required >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                   <label for="username">Nomor Rekening</label>
                   <input type="number" class="form-control text-center edit" id="update_account_number" name="account_number" placeholder="Enter Username" required >
               </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Perusahaan</label>
                    <input type="text" class="form-control text-center edit"  id="update_pic" name="pic" placeholder="PIC Perusahaan" required >
                 </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                   <label for="username">Status</label>
                   <br>
                   <input type="radio"  name="status"  class="edit"  value="true"> Aktif
                   <input type="radio" name="status" class="edit" value="false"> Non Aktif               
                </div>
               <div class="form-group col-md-6 col-sm-6">
                <label for="username">Status Komfirmasi Otomatis</label>
                <br>
                <input type="radio" class="edit" name="automatic_status" value="true"> Aktif
                <input type="radio" class="edit" name="automatic_status" value="false"> Non Aktif  
            </div>

            </div>

        </div>
        <div class="modal-footer float-left">
          <button type="submit" id="btnSave"  class="btn btn-primary ">Simpan</button>
          <button type="button" class="btn btn-danger btns" onclick="confirm_send('Tolak')">Cancel</button>
        </div>
    </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



  <div class="modal fade " id="tambahdata" role="dialog">
    <div class="modal-dialog extra">
      <div class="modal-content ">
  
        <div class="modal-header">
          <h3 class="modal-title">Tambah Data</h3>
          <button type="button" class="close" data-dismiss="modal" onclick="close_table();" >
            <span aria-hidden="true">&times;</span>
          </button>
  
        </div>
        <div class="modal-body form text-center">
        <div class="container" id='img_target_invoice'>
        </div>
        <br>
        <form  action="{{ route('admin.companies.store') }}" method="POST">

            @csrf

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="name">Nama Perusahaan</label>
                    <input type="text" class="form-control text-center edit"  name="name" placeholder="Enter Name" >
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="email">No Tlpn</label>
                    <input type="text" class="form-control text-center edit"  name="phone_number" placeholder="Phone Number" >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password">Email</label>
                    <input type="tenor" class="form-control text-center edit"  name="email" placeholder="Email" >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Kode Bank</label>
                    <select name="account_bank_id" class="form-control text-center">
                        @foreach($banks as $bank )
                            <option value="{{$bank->id}}" >{{$bank->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Atas Nama Pemilik</label>
                    <input type="text" class="form-control text-center edit" name="account_name" placeholder="Atas Nama Pemilik" required >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                   <label for="username">Nomor Rekening</label>
                   <input type="number" class="form-control text-center edit"  name="account_number" placeholder="Enter Username" required >
               </div>
                <div class="form-group col-md-6 col-sm-6">
                    <label for="username">Perusahaan</label>
                    <input type="text" class="form-control text-center edit"  name="pic" placeholder="PIC Perusahaan" required >
                 </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-sm-6">
                   <label for="username">Status</label>
                   <br>
                   <input type="radio"  name="status"  class="edit"  value="true"> Aktif
                   <input type="radio" name="status" class="edit" value="false"> Non Aktif               
                </div>
               <div class="form-group col-md-6 col-sm-6">
                <label for="username">Status Komfirmasi Otomatis</label>
                <br>
                <input type="radio" class="edit" name="automatic_status" value="true"> Aktif
                <input type="radio" class="edit" name="automatic_status" value="false"> Non Aktif  
            </div>

            </div>

        </div>
        <div class="modal-footer float-left">
          <button type="submit" id="btnSave"  class="btn btn-primary ">Simpan</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="close_table();" >
            <span aria-hidden="true">Close</span>
          </button>
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

        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

        var url="{{ route('admin.list_json_companies') }}";

        table =$("#tabeluser").DataTable({
            "responsive": true,
            "autoWidth": false,
            "bPaginate":true,
            "bInfo" : false,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "columns": [
                {data: 'name', name: 'name'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'email', name: 'email'},
                {data: 'pic', name:'pic'},
                {data: 'id', name: 'id', orderable: false, searchable: false},
            ],
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "render": function ( data, type, row ) {
                    return "<a class=\"btn btn-xs btn-outline-info\" title=\"View\" onclick=\"showData("+data+")\" data-target=\"#modalBorrowers\">Detail</a> <a class=\"btn btn-warning btn-xs\" data-toggle=\"modal\" title=\"View\" onclick=\"EditData("+data+")\" data-target=\"#modalBorrowers\">Edit</a>";
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
                    "type": "GET"
                },
        });

        function showData(id){

            $('.modal-title').text('');
            $("#modalshow").modal('show');

            var isurl="{{ route('admin.getCompany') }}";

            $.ajax({
                url :isurl,
                type : 'post',
                data: { "_token": "{{ csrf_token() }}","id":id},
                success : function(data){

                    var obj = JSON.parse(data);

                    $('#show_id').val(obj.id);
                    $('#show_name').val(obj.name);
                    $('#show_phone_number').val(obj.phone_number);
                    $('#show_email').val(obj.email);
                
                    $('#show_phone_number').val(obj.phone_number);
                    $('#show_account_bank_id').val(obj.account_bank_id);
                    $('#show_account_name').val(obj.account_name);
                    $('#show_pic').val(obj.pic);
                    $('#show_account_number').val(obj.account_number);

                    $('input[name="status"][value="' + obj.status + '"]').prop('checked', true);
                    $('input[name="automatic_status"][value="' + obj.automatic_status + '"]').prop('checked', true);

                    var url="{{ route('admin.companies.update',"") }}"+'/'+obj.id;
                    document.update_form.action = url;
                }
            })

        }

        function EditData(id){

            $('.modal-title').text('');
            $("#modal_form").modal('show');

            var isurl="{{ route('admin.getCompany') }}";

            $.ajax({
                url :isurl,
                type : 'post',
                data: { "_token": "{{ csrf_token() }}","id":id},
                success : function(data){

                    var obj = JSON.parse(data);

                    $('#update_id').val(obj.id);
                    $('#update_name').val(obj.name);
                    $('#update_phone_number').val(obj.phone_number);
                    $('#update_email').val(obj.email);
                
                    $('#update_phone_number').val(obj.phone_number);
                    $('#update_account_bank_id').val(obj.account_bank_id);
                    $('#update_account_name').val(obj.account_name);
                    $('#update_pic').val(obj.pic);
                    $('#update_account_number').val(obj.account_number);

                    $('input[name="status"][value="' + obj.status + '"]').prop('checked', true);
                    $('input[name="automatic_status"][value="' + obj.automatic_status + '"]').prop('checked', true);

                    var url="{{ route('admin.companies.update',"") }}"+'/'+obj.id;
                    document.update_form.action = url;

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