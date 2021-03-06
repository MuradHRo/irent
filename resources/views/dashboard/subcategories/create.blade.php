@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.subcategories')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('dashboard.subcategories.index')}}">@lang('site.subcategories')</a></li>
                        <li class="breadcrumb-item active">@lang('site.add')</li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">@lang('site.subcategories')</div>
            </div>
            <div class="card-body">
                <form action="{{route('dashboard.subcategories.store')}}" method="post">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('post')}}
                    <div class="form-group">
                        <label>@lang('site.categories')</label>
                        <select name="category_id" class="custom-select">
                            <option value="">@lang('site.categories')</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.icon')</label>
                        <input type="text" name="icon" class="form-control" value="{{old('icon')}}">
                    </div>
                    <div class="form-group">
                        <label for="">@lang('site.questions')</label>
                        <select name="question_ids[]" class="form-control select2" multiple="multiple">
                            @foreach($questions as $question)
                                <option value="{{$question->id}}">{{$question->question}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection