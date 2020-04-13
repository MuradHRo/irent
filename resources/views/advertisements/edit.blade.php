@extends('layouts.app')

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">@lang('site.advertisements')</div>
            </div>
            <div class="card-body">
                <form action="{{route('advertisements.update',$advertisement->id)}}" method="post" enctype="multipart/form-data">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('put')}}
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
                                <option
                                        value="{{$subcategory->id}}"
                                        @if($subcategory->id == $advertisement->subcategory_id)
                                        selected
                                        @endif
                                >{{$subcategory->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="questions_list">
                        @foreach($answers as $answer)
                            @php
                                $question=$answer->question;
                            @endphp
                            <div class="form-group">
                                <label>{{$question->question}}</label>
                                @if(!$question->selections->isEmpty())
                                    <select class="custom-select" name="selections[{{$question->id}}]">
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
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{$advertisement->name}}">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.short_description')</label>
                        <textarea name="short_description" class="form-control" cols="30" rows="2" maxlength="50">{{$advertisement->short_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>@lang('site.place')</label>
                        <input name="place" type="search" value="{{$advertisement->place}}" id="address-input" placeholder="@lang('site.search_place')" />
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
                        @if(is_array($advertisement->image_path))
                            <img src="{{$advertisement->image_path[0]}}" style="width: 100px" class="img-thumbnail" id="image_preview">
                        @else
                            <img src="{{$advertisement->image_path}}" style="width: 100px" class="img-thumbnail" id="image_preview">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>@lang('site.price')</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" name="price" class="form-control" value="{{$advertisement->price}}">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>@lang('site.price_per')</label>
                        <select name="price_per" class="custom-select">
                            <option value="">@lang('site.price_per')</option>
                            <option value="0" {{$advertisement->price_per == 0? 'selected':''}}>@lang('site.weak')</option>
                            <option value="1" {{$advertisement->price_per == 1? 'selected':''}}>@lang('site.month')</option>
                            <option value="2" {{$advertisement->price_per == 2? 'selected':''}}>@lang('site.year')</option>
                        </select>
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