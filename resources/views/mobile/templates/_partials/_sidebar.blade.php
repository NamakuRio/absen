<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">{{ $app_name }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">{{ $app_name_small }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Menu</li>
            <li class="{{ Request::route()->getName() == 'admin.dashboard' ? 'active' : '' }}"><a href="{{ route("admin.dashboard") }}" class="nav-link"><i class="fas fa-fire"></i><span>Beranda</span></a></li>
            @can('employee.view')
                <li class="{{ Request::route()->getName() == 'admin.employee' ? 'active' : '' }}"><a href="{{ route("admin.employee") }}" class="nav-link"><i class="fas fa-user-tie"></i><span>Karyawan</span></a></li>
            @endcan
            @can('presence.view')
                <li class="{{ Request::route()->getName() == 'admin.presence' ? 'active' : '' }}"><a href="{{ route("admin.presence") }}" class="nav-link"><i class="far fa-calendar-alt"></i><span>Kehadiran</span></a></li>
            @endcan
            @can('presence_type.view')
                <li class="{{ Request::route()->getName() == 'admin.presence_type' ? 'active' : '' }}"><a href="{{ route("admin.presence_type") }}" class="nav-link"><i class="far fa-keyboard"></i><span>Jenis Kehadiran</span></a></li>
            @endcan
            <li class="menu-header">Lainnya</li>
            <li class="{{ Request::route()->getName() == 'admin.account' ? 'active' : '' }}"><a href="{{ route("admin.account") }}" class="nav-link"><i class="far fa-user"></i><span>Akun</span></a></li>
            @if(auth()->user()->can('user.view') || auth()->user()->can('role.view') || auth()->user()->can('permission.view'))
                <li class="dropdown {{ Request::route()->getName() == 'admin.user' ? 'active' : '' }} {{ Request::route()->getName() == 'admin.role' ? 'active' : '' }} {{ Request::route()->getName() == 'admin.permission' ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users"></i> <span>Kelola Pengguna</span></a>
                    <ul class="dropdown-menu">
                        @can('user.view')
                            <li class="{{ Request::route()->getName() == 'admin.user' ? 'active' : '' }}"><a class="nav-link" href="{{ route("admin.user") }}">Pengguna</a></li>
                        @endcan
                        @can('role.view')
                            <li class="{{ Request::route()->getName() == 'admin.role' ? 'active' : '' }}"><a class="nav-link" href="{{ route("admin.role") }}">Peran</a></li>
                        @endcan
                        @can('permission.view')
                            <li class="{{ Request::route()->getName() == 'admin.permission' ? 'active' : '' }}"><a class="nav-link" href="{{ route("admin.permission") }}">Izin</a></li>
                        @endcan
                    </ul>
                </li>
            @endif
            @can('setting_group.view')
                <li class="{{ Request::route()->getPrefix() == 'admin/setting' ? 'active' : '' }}"><a href="{{ route("admin.setting.group") }}" class="nav-link"><i class="fas fa-cog"></i><span>Pengaturan</span></a></li>
            @endcan
        </ul>
    </aside>
</div>
