@extends('layouts.app')
@section('title', __('site.edit'))

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">@lang('site.advertisements')</div>
            </div>
            <div class="card-body">
                <form class="ui form" action="{{route('advertisements.update',$advertisement->id)}}" method="post" enctype="multipart/form-data">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('put')}}
                    <h4 class="ui dividing header mt-0">@lang('site.category_selection')</h4>
                    <div class="form-group">
                        <div class="ui search selection dropdown filter-input">
                            <input type="hidden" name="category" id="category" value="{{$advertisement->subcategory->category_id}}">
                            <i class="dropdown icon"></i>
                            <div class="default text">@lang('site.categories')</div>
                            <div class="menu">
                                @foreach($categories as $category)
                                    <div class="item {{$category->id== $advertisement->subcategory->category_id?'active selected':''}}" data-value="{{$category->id}}"><i class="{{$category->icon}}"></i> {{$category->name}}</div>
                                @endforeach
                            </div>
                        </div>
                        <span id="sub_categories_list" class="filter-input">
                            <div class="ui search selection dropdown mb-1">
                                <input type="hidden" name="subcategory_id" id="subcategory" value="{{$advertisement->subcategory_id}}">
                                <i class="dropdown icon"></i>
                                <div class="default text">@lang('site.all_sub_categories')</div>
                                <div class="menu">
                                    @foreach($sub_categories as $sub_category)
                                        <div class="item {{$category->id== $advertisement->subcategory_id?'active selected':''}}" data-value="{{$sub_category->id}}"><i class="{{$sub_category->icon}}"></i> {{$sub_category->name}}</div>
                                    @endforeach
                                </div>
                            </div>
                        </span>
                    </div>
                    <h4 class="ui dividing header mt-0">@lang('site.advertisement_info')</h4>
                    <div class="three fields">
                        <div class="field">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{$advertisement->name}}">
                        </div>
                        <div class="field filter-input">
                            <label style="display: unset!important;">@lang('site.place')</label>
                            <input style="padding: 0 35px;" name="place" type="search" value="{{$advertisement->place}}" id="address-input" placeholder="@lang('site.search_place')" />
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>@lang('site.short_description')</label>
                            <textarea name="short_description" class="form-control" cols="30" rows="2" maxlength="50" >{{$advertisement->short_description}}</textarea>
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label for="exampleInputFile">@lang('site.picture')</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image[]" class="custom-file-input" id="gallery-photo-add" multiple>
                                    <label class="custom-file-label" for="gallery-photo-add">@lang('site.choose_pic')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gallery">
                        @foreach($advertisement->image_path as $image)
                        <img src="{{$image}}" class="img-thumbnail mb-3" style="width: 100px;">
                        @endforeach
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>@lang('site.price')</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('site.egp')</span>
                                </div>
                                <input style="width: unset!important;"  type="number" name="price" class="form-control" value="{{$advertisement->price}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label>@lang('site.price_per')</label>
                            <select name="price_per" class="ui dropdown">
                                <option value="">@lang('site.price_per')</option>
                                <option value="0" {{$advertisement->price_per == 0? 'selected':''}}>@lang('site.day')</option>
                                <option value="1" {{$advertisement->price_per == 1? 'selected':''}}>@lang('site.weak')</option>
                                <option value="2" {{$advertisement->price_per == 2? 'selected':''}}>@lang('site.month')</option>
                                <option value="3" {{$advertisement->price_per == 3? 'selected':''}}>@lang('site.year')</option>
                            </select>
                        </div>
                    </div>
                    <div id="questions_list" class="three fields">
                        @foreach($answers as $answer)
                            @php
                                $question=$answer->question;
                            @endphp
                            <div class="field mb-1">
                                <label>{{$question->question}}</label>
                                @if(!$question->selections->isEmpty())
                                    <select class="ui dropdown w-100" name="selections[{{$question->id}}]">
                                        <option value="">{{$question->question}}</option>
                                        @foreach($question->selections as $selection)
                                            <option
                                                    value="{{$selection->id}}"
                                                    @if($selection->id==$answer->selection_id)
                                                    selected
                                                    @endif
                                            >{{$selection->name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" value="{{$answer->text}}" class="form-control" name="texts[{{$question->id}}]">
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info"></i>@lang('site.update')</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection