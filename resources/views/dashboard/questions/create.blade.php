@extends('layouts.dashboard.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('site.questions')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}"><i class="fa fa-tachometer-alt"></i> @lang('site.Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{route('dashboard.questions.index')}}">@lang('site.questions')</a></li>
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
                <div class="card-title">@lang('site.questions')</div>
            </div>
            <div class="card-body">
                <form action="{{route('dashboard.questions.store')}}" method="post">
                    @include('partials._errors')
                    {{csrf_field()}}
                    {{method_field('post')}}
                    <div class="form-group">
                        <label>@lang('site.question')</label>
                        <input type="text" name="question" class="form-control" value="{{old('question')}}">
                    </div>
                    <div>
                        <label>@lang('site.answer_type')</label>
                        <select name="selector_id" id="" class="form-control">
                            <option value="">@lang('site.text')</option>
                            @foreach($data as$selector_id=> $selections)
                                <option value="{{$selector_id}}">
                                        @foreach($selections as $selection)
                                        @if($loop->last)
                                            {{$selection}}
                                        @else
                                            {{$selection}} |
                                        @endif
                                        @endforeach
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>@lang('site.add')</button>
                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection