@extends('layouts.app')
@section('title', __('site.advertisements'))
@section('content')
    <div class="search-container mb-3">
        <form action="{{route('advertisements.index')}}" method="get">
            <div class="ui search selection dropdown filter-input">
                <input type="hidden" name="category" id="category" value="{{request()->category}}">
                <i class="dropdown icon"></i>
                <div class="default text">@lang('site.all_categories')</div>
                <div class="menu">
                    @foreach($categories as $category)
                        <div class="item {{$category->id==request()->category?'active selected':''}}" data-value="{{$category->id}}"><i class="{{$category->icon}}"></i> {{$category->name}}</div>
                    @endforeach
                </div>
            </div>
            <span id="sub_categories_list" class="filter-input">
                @if(isset(request()->sub_category))
                    @php
                        $sub_categories = \App\Category::findOrFail(request()->category)->subcategories;
                    @endphp
                    <div class="ui search selection dropdown mb-1">
                        <input type="hidden" name="sub_category" id="subcategory" value="{{request()->sub_category}}">
                        <i class="dropdown icon"></i>
                        <div class="default text">@lang('site.all_sub_categories')</div>
                        <div class="menu">
                            @foreach($sub_categories as $sub_category)
                                <div class="item {{$sub_category->id==request()->sub_category?'active selected':''}}" data-value="{{$sub_category->id}}"><i class="{{$sub_category->icon}}"></i> {{$sub_category->name}}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </span>
            <input name="place" value="{{request()->place}}" type="search" id="address-input" placeholder="@lang('site.any_place')" />
            <div class="ui input filter-input">
                <input type="text" value="{{request()->name}}" name="name" placeholder="@lang('site.advertisement_name')">
            </div>
            <div id="questions_list" class="filter-input d-inline">
                @if(isset(request()->sub_category))
                    @php
                        $questions = \App\Subcategory::findOrFail(request()->sub_category)->questions;
                        $question_key=1;
                        $text_key=1;
                    @endphp

                    @foreach($questions as $question)
                        <div class="field mb-1">
                            <label>{{$question->question}}</label>
                            @if(!$question->selections->isEmpty())
                                <select class="ui dropdown w-100" name="selections[{{$question->id}}]">
                                    <option value="">{{$question->question}}</option>
                                    @foreach($question->selections as $selection)
                                        <option {{$selection->id == request()->selections[$question_key]?'selected':''}} value="{{$selection->id}}">{{$selection->name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" value="{{request()->texts[$text_key]}}" placeholder="{{$question->question}}" class="form-control" name="texts[{{$question->id}}]">
                            @endif
                        </div>
                        @php
                            $question_key++;
                            $text_key++;
                        @endphp
                    @endforeach
                @endif
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
                <div class="col-12">
                    @if(isset(request()->subcategory_id))
                        <div class="ui unstackable steps">
                            <a class="step">
                                <i class="{{$subcategory->category->icon}}"></i>
                                <div class="content">
                                    <div class="title">{{$subcategory->category->name}}</div>
                                    <div class="description">@lang('site.category')</div>
                                </div>
                            </a>
                            <a class="active step">
                                <i class="{{$subcategory->icon}}"></i>
                                <div class="content">
                                    <div class="title">{{$subcategory->name}}</div>
                                    <div class="description">@lang('site.subcategory')</div>
                                </div>
                            </a>
                        </div>
                        {{--<h1 class="text-center"><span class="m-0 text-dark text-center">{{$subcategory->name}} <i class="{{$subcategory->icon}}"></i></span></h1>--}}
                    @else
                        <h2>@lang('site.search_results')</h2>
                    @endif
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @if($advertisements->count())
        <div class="ui three doubling stackable cards m-0">
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