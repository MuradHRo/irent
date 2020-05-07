@extends('layouts.app')
@section('title',__('site.about_us'))
@section('content')
    <a class="ui green big label mx-2">@lang('site.contact_us')</a>
    <div class="ui compact message mb-0">
        <p>@lang('site.contact_us_content')</p>
    </div>
    <div class="ui six doubling cards mt-1 px-3">
        @foreach($admins as $admin)
            <div style="cursor: pointer" class="ui card contact" data-id="{{$admin->id}}">
                <div class="image">
                    <img style="width: 100%;" src="{{$admin->image_path}}">
                </div>
                <div class="content">
                    <a class="header">{{$admin->name}}</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@include('layouts._footer')