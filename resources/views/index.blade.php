@extends('layouts.app')

@section('content')
    <div class="search-container mb-3">
        <form action="{{route('advertisements.index')}}" method="get">
            <div class="ui search selection dropdown">
                <input type="hidden" name="sub_category">
                <i class="dropdown icon"></i>
                <div class="default text">@lang('site.all_categories')</div>
                <div class="menu">
                    @foreach($sub_categories as $sub_category)
                    <div class="item" data-value="{{$sub_category->id}}"><i class="{{$sub_category->icon}}"></i> {{$sub_category->name}}</div>
                    @endforeach
                </div>
            </div>
            <input name="place" type="search" id="address-input" placeholder="@lang('site.any_place')" />
            <div class="ui input">
                <input type="text" name="name" placeholder="@lang('site.advertisement_name')">
            </div>
            <button type="submit" class="ui button green">
                <i class="search icon"></i> @lang('site.search')
            </button>
        </form>
    </div>
    <a class="ui red big label mx-2">@lang('site.new')</a>
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
    <a class="ui teal big label mx-2">@lang('site.about_us')</a>

@endsection