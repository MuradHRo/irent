@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.selections')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('dashboard.selections.index')}}">@lang('site.selections')</a></li>
                        <li class="breadcrumb-item active">@lang('site.edit')</li>

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
                <div class="card-title">@lang('site.selections')</div>
            </div>
            <div class="card-body">
                <form action="{{route('dashboard.selections.update',$selector_id)}}" method="post">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('put')}}
                    <div id="selection-container">
                        <label>@lang('site.selection_name')</label>
                        @foreach($selections as $selection)
                            <div class="form-group">
                                <input type="text" name="selection[]" class="form-control" value="{{$selection->name}}">
                            </div>
                        @endforeach
                    </div>
                    <div class="btn btn-info add-selection-btn">
                        <i class="fa fa-plus"></i>
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-info"></i>@lang('site.update')</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection