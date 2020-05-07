@extends('layouts.app')
@section('title', __('site.add_advertisement'))
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">@lang('site.advertisements')</div>
            </div>
            <div class="card-body">
                <form class="ui form" action="{{route('advertisements.store')}}" method="post" enctype="multipart/form-data">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('post')}}
                    <h4 class="ui dividing header mt-0">@lang('site.category_selection')</h4>
                    <div class="form-group">
                        <div class="ui search selection dropdown filter-input">
                            <input type="hidden" name="category" id="category">
                            <i class="dropdown icon"></i>
                            <div class="default text">@lang('site.categories')</div>
                            <div class="menu">
                                @foreach($categories as $category)
                                    <div class="item" data-value="{{$category->id}}"><i class="{{$category->icon}}"></i> {{$category->name}}</div>
                                @endforeach
                            </div>
                        </div>
                        <span id="sub_categories_list" class="filter-input">

                        </span>
                    </div>
                    <h4 class="ui dividing header mt-0">@lang('site.advertisement_info')</h4>
                    <div class="three fields">
                        <div class="field">
                            <label>@lang('site.name')</label>
                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                        </div>
                        <div class="field filter-input">
                            <label style="display: unset!important;">@lang('site.place')</label>
                            <input style="padding: 0 35px;" name="place" type="search" id="address-input" placeholder="@lang('site.search_place')" />
                        </div>
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>@lang('site.short_description')</label>
                            <textarea name="short_description" class="form-control" cols="30" rows="2" maxlength="50" >{{old('short_description')}}</textarea>
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
{{--                        <img src="{{asset('uploads/advertisement_images/default.png')}}" style="width: 100px" class="img-thumbnail mb-3" id="image_preview" alt="">--}}
                    </div>
                    <div class="three fields">
                        <div class="field">
                            <label>@lang('site.price')</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('site.egp')</span>
                                </div>
                                <input style="width: unset!important;" type="number" name="price" class="form-control" value="{{old('price')}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label>@lang('site.price_per')</label>
                            <select name="price_per" class="ui dropdown">
                                <option value="">@lang('site.price_per')</option>
                                <option value="0">@lang('site.day')</option>
                                <option value="1">@lang('site.weak')</option>
                                <option value="2">@lang('site.month')</option>
                                <option value="3">@lang('site.year')</option>
                            </select>
                        </div>
                    </div>
                    <div id="questions_list" class="three fields">

                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection