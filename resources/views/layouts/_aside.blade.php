<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{--<a href="index3.html" class="brand-link">--}}
        {{--<img src="{{asset('dashboard/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"--}}
             {{--style="opacity: .8">--}}
        {{--<span class="brand-text font-weight-light">AdminLTE 3</span>--}}
    {{--</a>--}}

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
        @php
            $categories=\App\Category::all();
        @endphp
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
            @foreach($categories as $category)
                <li class="nav-item has-treeview
                    @if(isset($category_id))
                        {{$category->id==$category_id?'menu-open':''}}
                    @endif
                    ">
                    <a href="" class="nav-link
                        @if(isset($category_id))
                            {{$category->id==$category_id?'active':''}}
                        @endif
                        " id="nav-category">
                        <i class="nav-icon {{$category->icon}}"></i>
                        <p>
                            {{$category->name}}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="
                    @if(isset($category_id))
                        {{$category->id==$category_id?'display: block':'display: none'}}
                    @endif
                    ">
                    @foreach($category->subcategories as $subcategory)
                            <li class="nav-item">
                                <a href="{{route('advertisements.index',['subcategory_id'=>$subcategory->id])}}" class="nav-link
                                    @if(isset($subcategory_id))
                                        {{$subcategory->id==$subcategory_id?'active':''}}
                                    @endif
                                    ">
                                    <i class="{{$subcategory->icon}} nav-icon"></i>
                                    <p>{{$subcategory->name}}</p>
                                </a>
                            </li>
                    @endforeach
                    </ul>
                </li>
            @endforeach
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