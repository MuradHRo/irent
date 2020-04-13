@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.advertisements') <small>{{$advertisements->total()}}</small>  </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('site.advertisements')</li>
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
                <div class="card-title">@lang('site.advertisements')</div>
                <form action="{{route('dashboard.advertisements.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="@lang('site.search')" value="{{request()->search}}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-search px-1"></i>@lang('site.search')</button>
                            @if(auth()->user()->hasPermission('create_advertisements'))
                                <a class="btn bg-gradient-success btn-sm" href="{{route('dashboard.advertisements.create')}}"><i class="fa fa-plus px-1"></i>@lang('site.add')</a>
                            @else
                                <button class="btn bg-gradient-success" disabled >@lang('site.add')</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive">
                @if($advertisements->count())
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.short_description')</th>
                                <th>@lang('site.subcategory')</th>
                                <th>@lang('site.user')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($advertisements as $index=>$advertisement)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$advertisement->name}}</td>
                                    <td>{{$advertisement->short_description}}</td>
                                    <td>{{$advertisement->subcategory->name}}</td>
                                    <td>{{$advertisement->user->name}}</td>
                                    <td>{{$advertisement->price}}</td>
                                    <td>
                                        @if(is_array($advertisement->image_path))
                                            <img src="{{$advertisement->image_path[0]}}" style="width: 100px" class="img-thumbnail">
                                        @else
                                            <img src="{{$advertisement->image_path}}" style="width: 100px" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>{{$advertisement->name}}</td>

                                    <td class="text-center">
                                        @if(auth()->user()->hasPermission('update_advertisements'))
                                            <a class="btn btn-info m-1 btn-sm" href="{{route('dashboard.advertisements.edit',$advertisement->id)}}"><i class="fa fa-edit px-1"></i>@lang('site.edit')</a>
                                        @else
                                            <button disabled class="btn m-1 btn-info btn-sm">@lang('site.edit')</button>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_advertisements'))
                                            <form class="d-inline-block" action="{{route('dashboard.advertisements.destroy',$advertisement->id)}}" method="post">
                                                {{csrf_field()}}
                                                {{method_field('delete')}}
                                                <button type="submit" class="btn m-1 btn-danger btn-sm"><i class="fa fa-trash-alt px-1"></i>@lang('site.delete')</button>
                                            </form>
                                        @else
                                            <button disabled class="btn btn-danger m-1 btn-sm">@lang('site.delete')</button>
                                        @endif
                                            <a class="btn m-1 btn-warning btn-sm" href="{{route('dashboard.advertisements.show',$advertisement->id)}}"><i class="fa fa-info px-1"></i>@lang('site.show_details')</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$advertisements->appends(request()->query())->links()}}
                @else
                    <h2>@lang('site.no_data_found')</h2>
                @endif
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection