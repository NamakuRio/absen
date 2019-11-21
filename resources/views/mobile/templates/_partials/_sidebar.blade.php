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
            <li class="menu-header">Lainnya</li>
            <li class="{{ Request::route()->getName() == 'admin.account' ? 'active' : '' }}"><a href="{{ route("admin.account") }}" class="nav-link"><i class="far fa-user"></i><span>Akun</span></a></li>
            @can('user.view')
                <li class="{{ Request::route()->getName() == 'admin.user' ? 'active' : '' }}"><a href="{{ route("admin.user") }}" class="nav-link"><i class="fas fa-users"></i><span>Pengguna</span></a></li>
            @endcan
            @if(auth()->user()->can('setting.view') || auth()->user()->can('permission.view') || auth()->user()->can('role.view'))
                <li class="dropdown {{ Request::route()->getName() == 'admin.setting' ? 'active' : '' }} {{ Request::route()->getName() == 'admin.permission' ? 'active' : '' }} {{ Request::route()->getName() == 'admin.role' ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i> <span>Pengaturan</span></a>
                    <ul class="dropdown-menu">
                        @can('setting.view')
                            <li class="{{ Request::route()->getName() == 'admin.setting' ? 'active' : '' }}"><a class="nav-link" href="{{ route("admin.setting") }}">Pengaturan Umum</a></li>
                        @endcan
                        @can('permission.view')
                            <li class="{{ Request::route()->getName() == 'admin.permission' ? 'active' : '' }}"><a class="nav-link" href="{{ route("admin.permission") }}">Izin</a></li>
                        @endcan
                        @can('role.view')
                            <li class="{{ Request::route()->getName() == 'admin.role' ? 'active' : '' }}"><a class="nav-link" href="{{ route("admin.role") }}">Peran</a></li>
                        @endcan
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
</div>
