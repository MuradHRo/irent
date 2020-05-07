@extends('layouts.app')
@section('title',__('site.about_us'))
@section('content')
    <div class="ui piled segment mt-2 mb-0 mx-3">@lang('site.about_us_content')</div>
@endsection
@include('layouts._footer')