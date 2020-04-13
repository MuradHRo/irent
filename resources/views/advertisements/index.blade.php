@extends('layouts.app')

@section('content')
    <div class="search-container mb-3">
        <form action="{{route('advertisements.index')}}" method="get">
            <div class="ui search selection dropdown">
                <input type="hidden" name="sub_category" value="{{request()->sub_category}}">
                <i class="dropdown icon"></i>
                <div class="default text">@lang('site.all_categories')</div>
                <div class="menu">
                    @foreach($sub_categories as $sub_category)
                        <div class="item {{$sub_category->id==request()->sub_category?'active selected':''}}"   data-value="{{$sub_category->id}}"><i class="{{$sub_category->icon}}"></i> {{$sub_category->name}}</div>
                    @endforeach
                </div>
            </div>
            <input name="place" value="{{request()->place}}" type="search" id="address-input" placeholder="@lang('site.any_place')" />
            <div class="ui input">
                <input type="text" name="name" value="{{request()->name}}" placeholder="@lang('site.advertisement_name')">
            </div>
            <button type="submit" class="ui button green">
                 <i class="search icon"></i> @lang('site.search')
            </button>
        </form>
    </div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.advertisements')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('index')}}"><i class="fa fa-home"></i> @lang('site.home')</a></li>
                        @if(!$subcategory_id==0)
                        <li class="breadcrumb-item active">{{$subcategory->name}} <i class="{{$subcategory->icon}}"></i></li>
                        @endif
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if($advertisements->count())
        <div class="ui three doubling cards m-0">
            @foreach($advertisements as $advertisement)
                <div class="ui card">
                    @if(!$advertisement->available_status)
                    <a class="ui red ribbon label">@lang('site.not_available')</a>
                    @endif
                    <div class="content">
                        <span class="meta right floated">{{$advertisement->time_ago}}</span>
                        <a href="{{route('users.profile',$advertisement->user->id)}}" class="left floated">
                            <img class="ui avatar image" src="{{$advertisement->user->image_path}}"> {{$advertisement->user->name}}
                        </a>
                    </div>
                    <div class="image">
                        <span class="place">
                            <i class="map marker icon"></i>{{$advertisement->place}}
                        </span>
                        @if(is_array($advertisement->image_path))
                            <img src="{{$advertisement->image_path[0]}}">
                        @else
                            <img src="{{$advertisement->image_path}}">
                        @endif
                    </div>
                    <div class="content">
                        <div class="right floated">
                            <div class="ui star rating read" data-rating="{{$advertisement->rate}}" data-max-rating="5"></div>
                        </div>
                        <span class="left floated">
                            <i class="comment icon"></i>
                        {{$advertisement->comments->count()}} @lang('site.comments')
                        </span>
                    </div>
                    <div class="content">
                        <div class="right floated">{{$advertisement->price}} @lang('site.egp') {{$advertisement->price_per_x}}</div>
                        <a href="{{route('advertisements.show',$advertisement->id)}}" class="header left floated">{{$advertisement->name}}</a>
                        <div class="description">
                            {{$advertisement->short_description}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            <div class="d-inline-block">
                {{$advertisements->appends(request()->query())->links()}}
            </div>
        </div>
    @else
        <h2 class="m-5">@lang('site.no_data_found')</h2>
    @endif
@endsection