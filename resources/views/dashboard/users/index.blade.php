@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.users') <small>{{$users->total()}}</small>  </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('site.users')</li>
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
                <div class="card-title">@lang('site.users')</div>
                <form action="{{route('dashboard.users.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{request()->search}}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-search px-1"></i>@lang('site.search')</button>
                            @if(auth()->user()->hasPermission('create_users'))
                                <a class="btn bg-gradient-success btn-sm" href="{{route('dashboard.users.create')}}"><i class="fa fa-plus px-1"></i>@lang('site.add')</a>
                            @else
                                <button class="btn bg-gradient-success" disabled >@lang('site.add')</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if($users->count())
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.email')</th>
                            <th>@lang('site.picture')</th>
                            <th>@lang('site.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $index=>$user)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td><img src="{{$user->image_path}}" style="width: 100px" class="img-thumbnail" alt=""></td>
                                <td>
                                    @if(auth()->user()->hasPermission('update_users'))
                                        <a class="btn btn-info btn-sm" href="{{route('dashboard.users.edit',$user->id)}}"><i class="fa fa-edit px-1"></i>@lang('site.edit')</a>
                                    @else
                                        <button disabled class="btn btn-info btn-sm">@lang('site.edit')</button>
                                    @endif
                                    @if(auth()->user()->hasPermission('delete_users'))
                                        <form class="d-inline-block" action="{{route('dashboard.users.destroy',$user->id)}}" method="post">
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
                    {{$users->appends(request()->query())->links()}}
                @else
                    <h2>@lang('site.no_data_found')</h2>
                @endif
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection