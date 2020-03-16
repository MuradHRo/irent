@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.selections') <small>{{$selections->count()}}</small>  </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('site.selections')</li>
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
                <form action="{{route('dashboard.selections.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{request()->search}}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-search px-1"></i>@lang('site.search')</button>
                            @if(auth()->user()->hasPermission('create_selections'))
                                <a class="btn bg-gradient-success btn-sm" href="{{route('dashboard.selections.create')}}"><i class="fa fa-plus px-1"></i>@lang('site.add')</a>
                            @else
                                <button class="btn bg-gradient-success" disabled >@lang('site.add')</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($selections->count())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index=> $selections)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <ul class="list-unstyled">
                                            @foreach($selections as $selection)
                                                <li>{{$selection}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_selections'))
                                            <a class="btn btn-info btn-sm" href="{{route('dashboard.selections.edit',$index)}}"><i class="fa fa-edit px-1"></i>@lang('site.edit')</a>
                                        @else
                                            <button disabled class="btn btn-info btn-sm">@lang('site.edit')</button>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_selections'))
                                            <form class="d-inline-block" action="{{route('dashboard.selections.destroy',$index)}}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('delete')}}
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt px-1"></i>@lang('site.delete')</button>
                                            </form>
                                        @else
                                            <button disabled class="btn btn-danger btn-sm">@lang('site.delete')</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h2>@lang('site.no_data_found')</h2>
                @endif
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection