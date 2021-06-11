<!-- Top Bar Start -->
<div class="topbar">

<nav class="navbar-custom">
    <!-- Search input -->
    <!---<div class="search-wrap" id="search-wrap">
        <div class="search-bar">
            <input class="search-input" type="search" placeholder="Search" />
            <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                <i class="mdi mdi-close-circle"></i>
            </a>
        </div>
    </div>--->

    <ul class="list-inline float-right mb-0">
        <!-- Search -->
        <!---<li class="list-inline-item dropdown notification-list">
            <a class="nav-link waves-effect toggle-search" href="#"  data-target="#search-wrap">
                <i class="mdi mdi-magnify noti-icon"></i>
            </a>
        </li>--->
        <!-- Fullscreen -->
        <li class="list-inline-item dropdown notification-list hidden-xs-down">
            <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                <i class="mdi mdi-fullscreen noti-icon"></i>
            </a>
        </li>
        <!-- User-->
        <li class="list-inline-item dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="javascript:void(0)" role="button"
            aria-haspopup="false" aria-expanded="false">
                <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="user" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                @can('profile_password_edit')
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="dripicons-user text-muted"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                @endcan
                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="dripicons-exit text-muted"></i> Logout</a>
                <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
    <!-- Page title -->
    <ul class="list-inline menu-left mb-0">
        <li class="list-inline-item">
            <button type="button" class="button-menu-mobile open-left waves-effect">
                <i class="ion-navicon"></i>
            </button>
        </li>
        <li class="hide-phone list-inline-item app-search">
            @yield('breadcrumb') 
        </li>
    </ul>
    <div class="clearfix"></div>
</nav>
</div>
<!-- Top Bar End -->