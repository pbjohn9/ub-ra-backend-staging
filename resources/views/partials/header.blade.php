<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">

<!-- LOGO -->
<div class="topbar-left">
    <div class="">
        <!--<a href="index" class="logo text-center">Admiria</a>-->
        <a href="{{ route('home') }}" class="logo"><img src="{{ URL::asset('assets/images/ultimatebundles_icon.png') }}" height="36" alt="logo"></a>
    </div>
</div>

<div class="sidebar-inner slimscrollleft">
    <div id="sidebar-menu">
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="waves-effect {{ request()->is('dashboard') ? "active" : "" }}">
                    <i class="mdi mdi-home-modern"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            @can('user_management_access')
                <li>
                    <a href="{{ route('users.index') }}" class="waves-effect {{ request()->is('users') || request()->is('users/*') ? 'active' : '' }}">
                        <i class="mdi mdi-account"></i>
                        <span>{{ __('Users') }}</span>
                    </a>
                </li>
            @endcan

            @can('permission_access')
                <li>
                    <a href="{{ route('permissions.index') }}" class="waves-effect {{ request()->is('permissions') || request()->is('permissions/*') ? 'active' : '' }}">
                        <i class="mdi mdi-account"></i>
                        <span>{{ __('Permissions') }}</span>
                    </a>
                </li>
            @endcan

            @can('role_access')
                <li>
                    <a href="{{ route('roles.index') }}" class="waves-effect {{ request()->is('roles') || request()->is('roles/*') ? 'active' : '' }}">
                        <i class="mdi mdi-account"></i>
                        <span>{{ __('Roles') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="clearfix"></div>
</div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
