 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">Admin</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li class="active">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                        <ul class="collapse">
                            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('role.create') || $usr->can('role.view') ||  $usr->can('role.edit') ||  $usr->can('role.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                            Roles & Permissions
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : '' }}">
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                            @endif
                            @if ($usr->can('role.create'))
                                <li class="{{ Route::is('admin.roles.create')  ? 'active' : '' }}"><a href="{{ route('admin.roles.create') }}">Create Role</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    
                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Admins
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}">All Admins</a></li>
                            @endif

                            @if ($usr->can('admin.create'))
                                <li class="{{ Route::is('admin.admins.create')  ? 'active' : '' }}"><a href="{{ route('admin.admins.create') }}">Create Admin</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('company.create') || $usr->can('company.view') ||  $usr->can('company.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Perusahaan
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.company.create') || Route::is('admin.company.index') || Route::is('admin.company.edit') || Route::is('admin.company.show') ? 'in' : '' }}">
                            @if ($usr->can('company.view'))
                            <li class="{{ Route::is('admin.companies.index')  || Route::is('admin.companies.edit') ? 'active' : '' }}"><a href="{{ route('admin.companies.index') }}">Data Perusahaan</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('lending.create') || $usr->can('lending.view') ||  $usr->can('lending.edit') ||  $usr->can('lending.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Konfirmasi Pinjaman 
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.lending.create') || Route::is('admin.lending.index') || Route::is('admin.lending.edit') || Route::is('admin.lending.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('lending.view'))
                                <li class="{{ Route::is('admin.lendings.index')  || Route::is('admin.lending.edit') ? 'active' : '' }}"><a href="{{ route('admin.lendings.index') }}">List Pinjaman</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('borrowers.create') || $usr->can('borrowers.view') ||  $usr->can('borrowers.edit') ||  $usr->can('borrowers.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Peminjam 
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.borrowers.create') || Route::is('admin.borrowers.index') || Route::is('admin.borrowers.edit') || Route::is('admin.borrowers.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.borrowers.index')  || Route::is('admin.borrowers.edit') ? 'active' : '' }}"><a href="{{route('admin.borrowers.index') }}">List Peminjam</a></li>
                            @endif

                            {{-- @if ($usr->can('admin.create'))
                                <li class="{{ Route::is('admin.admins.create')  ? 'active' : '' }}"><a href="{{ route('admin.admins.create') }}">Create Admin</a></li>
                            @endif --}}
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('product.create') || $usr->can('product.view') ||  $usr->can('product.edit') ||  $usr->can('product.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Akses Pinjaman
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.products.create') || Route::is('admin.products.index') || Route::is('admin.products.edit') || Route::is('admin.products.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('product.view'))
                                <li class="{{ Route::is('admin.products.index')  || Route::is('admin.products.edit') ? 'active' : '' }}"><a href="{{ route('admin.products.index') }}">List Product</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->

