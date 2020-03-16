@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.admins')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('dashboard.admins.index')}}">@lang('site.admins')</a></li>
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
                <div class="card-title">@lang('site.admins')</div>
            </div>
            <div class="card-body">
                <form action="{{route('dashboard.admins.update',$user->id)}}" method="post" enctype="multipart/form-data">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('put')}}
                    <div class="form-group">
                        <label>@lang('site.name')</label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.email')</label>
                        <input type="text" name="email" class="form-control" value="{{$user->email}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">@lang('site.picture')</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">@lang('site.choose_pic')</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="{{$user->image_path}}" style="width: 100px" class="img-thumbnail mb-3" id="image_preview" alt="">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.permissions')</label>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3"></h3>
                            @php
                                $models=['users','admins','categories','subcategories','advertisements','questions','selections'];
                                $maps=['create','read','update','delete'];
                            @endphp
                            <ul class="nav nav-pills ml-auto p-2">
                                @foreach($models as $index=>$model)
                                    <li class="nav-item"><a class="nav-link {{$index==0?'active':''}}" href="#{{$model}}" data-toggle="tab">@lang('site.'.$model)</a></li>
                                @endforeach
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                @foreach($models as $index=>$model)
                                    <div class="tab-pane {{$index==0?'active':''}}" id="{{$model}}">
                                        @foreach($maps as $map)
                                            <label><input type="checkbox" name="permissions[]" {{$user->hasPermission($map.'_'.$model)?'checked':''}} value="{{$map}}_{{$model}}">@lang('site.'.$map)</label>
                                        @endforeach
                                    </div>
                            @endforeach
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
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