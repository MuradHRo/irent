<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item push-menu">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <a href="{{route('index')}}" class="nav-link">@lang('site.home')</a>
        </li>
        @if(!auth()->user())
            <li class="nav-item d-sm-inline-block">
                <a href="{{route('login')}}" class="nav-link">@lang('site.login')</a>
            </li>
            <li class="nav-item d-sm-inline-block">
                <a href="{{route('register')}}" class="nav-link">@lang('site.register')</a>
            </li>
        @endif
        @if(auth()->user())
            @if(auth()->user()->hasRole('admin|super_admin'))
                <li class="nav-item d-sm-inline-block">
                    <a href="{{route('dashboard.index')}}" class="nav-link">@lang('site.Dashboard')</a>
                </li>
            @endif
        @endif
        <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-flag"></i></a>
            <ul class="dropdown-menu">
                <li>
                    <ul class="menu p-0">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class="dropdown-item">
                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        @if(auth()->user())
            <li class="nav-item d-sm-inline-block">
                <a href="{{route('advertisements.create')}}" class="ui teal button tiny"><i class="fa fa-plus mx-1"></i>@lang('site.add_advertisement')</a>
            </li>
        @endif
    </ul>
    <!-- SEARCH FORM -->
    {{--<form class="form-inline ml-3">--}}
        {{--<div class="input-group input-group-sm">--}}
            {{--<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
            {{--<div class="input-group-append">--}}
                {{--<button class="btn btn-navbar" type="submit">--}}
                    {{--<i class="fas fa-search"></i>--}}
                {{--</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}

    <!-- Right navbar links -->
    {{--<ul class="navbar-nav ml-auto">--}}
        {{--<!-- Messages Dropdown Menu -->--}}
        {{--<li class="nav-item dropdown">--}}
            {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                {{--<i class="far fa-comments"></i>--}}
                {{--<span class="badge badge-danger navbar-badge">3</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<!-- Message Start -->--}}
                    {{--<div class="media">--}}
                        {{--<img src="{{asset('dashboard/dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
                        {{--<div class="media-body">--}}
                            {{--<h3 class="dropdown-item-title">--}}
                                {{--Brad Diesel--}}
                                {{--<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
                            {{--</h3>--}}
                            {{--<p class="text-sm">Call me whenever you can...</p>--}}
                            {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- Message End -->--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<!-- Message Start -->--}}
                    {{--<div class="media">--}}
                        {{--<img src="{{asset('dashboard/dist/img/user8-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                        {{--<div class="media-body">--}}
                            {{--<h3 class="dropdown-item-title">--}}
                                {{--John Pierce--}}
                                {{--<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
                            {{--</h3>--}}
                            {{--<p class="text-sm">I got your message bro</p>--}}
                            {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- Message End -->--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<!-- Message Start -->--}}
                    {{--<div class="media">--}}
                        {{--<img src="{{asset('dashboard/dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
                        {{--<div class="media-body">--}}
                            {{--<h3 class="dropdown-item-title">--}}
                                {{--Nora Silvester--}}
                                {{--<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
                            {{--</h3>--}}
                            {{--<p class="text-sm">The subject goes here</p>--}}
                            {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<!-- Message End -->--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<!-- Notifications Dropdown Menu -->--}}
        {{--<li class="nav-item dropdown">--}}
            {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
                {{--<i class="far fa-bell"></i>--}}
                {{--<span class="badge badge-warning navbar-badge">15</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
                {{--<span class="dropdown-item dropdown-header">15 Notifications</span>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fas fa-envelope mr-2"></i> 4 new messages--}}
                    {{--<span class="float-right text-muted text-sm">3 mins</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fas fa-users mr-2"></i> 8 friend requests--}}
                    {{--<span class="float-right text-muted text-sm">12 hours</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item">--}}
                    {{--<i class="fas fa-file mr-2"></i> 3 new reports--}}
                    {{--<span class="float-right text-muted text-sm">2 days</span>--}}
                {{--</a>--}}
                {{--<div class="dropdown-divider"></div>--}}
                {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
            {{--</div>--}}
        {{--</li>--}}
        {{--<li class="nav-item">--}}
            {{--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
                {{--<i class="fas fa-th-large"></i>--}}
            {{--</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
</nav>
<!-- /.navbar -->