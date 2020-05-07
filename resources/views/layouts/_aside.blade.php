<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('index')}}" class="brand-link">
        <img src="{{asset('uploads/i rent logo 2.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">IRent</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @if(auth()->user())
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->image_path}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('users.profile',auth()->user()->id)}}" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>
        @endif
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('index')}}" class="nav-link">
                        <i class="nav-icon fa fa-home text-green"></i>
                        <p class="text">@lang('site.home')</p>
                    </a>
                </li>
            @if(auth()->user() && auth()->user()->hasRole('admin|super_admin'))
                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}" class="nav-link">
                        <i class="nav-icon fa fa-tachometer-alt text-blue"></i>
                        <p class="text">@lang('site.Dashboard')</p>
                    </a>
                </li>
            @endif
            @if(auth()->user())
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">@lang('site.logout')</p>
                    </a>
                </li>
            @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>