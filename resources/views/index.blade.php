@extends('layouts.app')
@section('title', __('site.home'))

@section('content')
    <div class="search-container">
        <form action="{{route('advertisements.index')}}" method="get">
            <div class="ui search selection dropdown filter-input">
                <input type="hidden" name="category" id="category">
                <i class="dropdown icon"></i>
                <div class="default text">@lang('site.all_categories')</div>
                <div class="menu">
                    @foreach($categories as $category)
                    <div class="item" data-value="{{$category->id}}"><i class="{{$category->icon}}"></i> {{$category->name}}</div>
                    @endforeach
                </div>
            </div>
            <span id="sub_categories_list" class="filter-input">

            </span>
            <input name="place" type="search" id="address-input" placeholder="@lang('site.any_place')" />
            <div class="ui input filter-input">
                <input type="text" name="name" placeholder="@lang('site.advertisement_name')">
            </div>
            <div id="questions_list" class="filter-input d-inline">

            </div>

            <button type="submit" class="ui button green">
                <i class="search icon"></i> @lang('site.search')
            </button>
        </form>
    </div>
    <div class="categories pt-3 px-3" >
        @php
            $backgrounds=['#48b86a','#0990d0','#ef406e','#f89728','#159b97','#842e88','#73cfed','#e66e79','#b96827','#b0bc22','#993300','#8CAAAE'];
        @endphp
        @foreach($categories as $category)
            <h4 class="ui header main-category" style="background:{{$backgrounds[array_rand($backgrounds)]}}">
                <span style="padding: 5px">
                    <i  class="{{$category->icon}}"></i>
                </span>
                <span class="name">{{$category->name}}</span>
            </h4>
            <div class="sub-categories">
                @foreach($category->subcategories as $sub_category)
                    <div class="li fleft">
                        <div class="item">
                            <a href="{{route('advertisements.index',['subcategory_id'=>$sub_category->id])}}" class="link parent">
                                <i style="background:{{$backgrounds[array_rand($backgrounds)]}} " class="{{$sub_category->icon}} icon--circle"></i>
                                <span class="font-weight-bold">{{$sub_category->name}}</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @if(count($last_ads))
    <h3 class="title-olx mt-5 mb-3">@lang('site.new')</h3>
    @endif
    <div class="ui three doubling stackable cards m-0">
    @foreach($last_ads as $advertisement)
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
    {{--<a class="ui teal big label mx-2">@lang('site.about_us')</a>--}}
@endsection
@section('footer')
@include('layouts._footer')
@endsection