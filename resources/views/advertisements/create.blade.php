@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">@lang('site.advertisements')</div>
            </div>
            <div class="card-body">
                <form action="{{route('advertisements.store')}}" method="post" enctype="multipart/form-data">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('post')}}
                    <div class="form-group">
                        <label>@lang('site.subcategories')</label>
                        <select
                                name="subcategory_id"
                                class="custom-select"
                                id="subcategory"
                                data-method="get"
                        >
                            <option value="">@lang('site.subcategories')</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group">
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.short_description')</label>
                        <textarea name="short_description" class="form-control" cols="30" rows="2" maxlength="50" ></textarea>
                    </div>
                    <div class="form-group">
                        <label>@lang('site.place')</label>
                        <input name="place" type="search" id="address-input" placeholder="@lang('site.search_place')" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">@lang('site.picture')</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image[]" class="custom-file-input" id="image" multiple>
                                <label class="custom-file-label" for="image">@lang('site.choose_pic')</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="{{asset('uploads/advertisement_images/default.png')}}" style="width: 100px" class="img-thumbnail mb-3" id="image_preview" alt="">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.price')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" name="price" class="form-control" value="{{old('purchase_price')}}">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('site.price_per')</label>
                        <select name="price_per" class="custom-select">
                            <option value="">@lang('site.price_per')</option>
                            <option value="0">@lang('site.weak')</option>
                            <option value="1">@lang('site.month')</option>
                            <option value="2">@lang('site.year')</option>
                        </select>
                    </div>
                    <div id="questions_list">

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