<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{--<a href="index3.html" class="brand-link">--}}
        {{--<img src="{{asset('dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"--}}
             {{--style="opacity: .8">--}}
        {{--<span class="brand-text font-weight-light">AdminLTE 3</span>--}}
    {{--</a>--}}

    <!-- Sidebar -->
    @if(auth()->user())
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{auth()->user()->image_path}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-home "></i>
                        <p>
                            @lang('site.Dashboard')
                        </p>
                    </a>
                </li>
                @if(auth()->user()->hasPermission('read_admins'))
                    <li class="nav-item">
                        <a href="{{route('dashboard.admins.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                @lang('site.admins')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('read_users'))
                <li class="nav-item">
                        <a href="{{route('dashboard.users.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                @lang('site.users')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('read_categories'))
                    <li class="nav-item">
                        <a href="{{route('dashboard.categories.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                @lang('site.categories')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('read_subcategories'))
                    <li class="nav-item">
                        <a href="{{route('dashboard.subcategories.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-th-list"></i>
                            <p>
                                @lang('site.subcategories')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('read_advertisements'))
                    <li class="nav-item">
                        <a href="{{route('dashboard.advertisements.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-ad"></i>
                            <p>
                                @lang('site.advertisements')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('read_questions'))
                    <li class="nav-item">
                        <a href="{{route('dashboard.questions.index')}}" class="nav-link">
                            <i class="nav-icon fas fa-question"></i>
                            <p>
                                @lang('site.questions')
                            </p>
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasPermission('read_selections'))
                    <li class="nav-item">
                        <a href="{{route('dashboard.selections.index')}}" class="nav-link">
                            <i class="nav-icon fa fa-check-square"></i>
                            <p>
                                @lang('site.selections')
                            </p>
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
    @endif
    <!-- /.sidebar -->
</aside>