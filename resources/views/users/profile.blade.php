@extends('layouts.app')
@section('title', __($user->name))

@section('content')
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{$user->image_path}}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{$user->name}}</h3>

                            {{--<p class="text-muted text-center">Software Engineer</p>--}}

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>@lang('site.advertisements')</b> <a class="float-right">{{$advertisements->count()}}</a>
                                </li>
                                {{--<li class="list-group-item">--}}
                                    {{--<b>Following</b> <a class="float-right">543</a>--}}
                                {{--</li>--}}
                                {{--<li class="list-group-item">--}}
                                    {{--<b>Friends</b> <a class="float-right">13,287</a>--}}
                                {{--</li>--}}
                            </ul>

                            <a style="cursor: pointer;color: white" data-id="{{$user->id}}" class="btn btn-primary btn-block contact"><b>@lang('site.send_msg')</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                            <p class="text-muted">Malibu, California</p>

                            <hr>

                            <strong><i class="fas fa-mobile mr-1"></i> Mobile</strong>

                            <p class="text-muted">
                            </p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">@lang('site.available_advertisements')</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">@lang('site.ended_advertisements')</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    @if($advertisements->count())
                                        <div class="ui two doubling stackable cards m-0">
                                            @foreach($advertisements as $advertisement)
                                                <div class="ui card">
                                                    {{--<a class="ui red ribbon label">Not Available</a>--}}
                                                    <div class="content">
                                                        <span class="meta right floated">{{$advertisement->time_ago}}</span>
                                                        <a href="{{route('users.profile',$advertisement->user->id)}}" class="left floated">
                                                            <img class="ui avatar image" src="{{$advertisement->user->image_path}}"> {{$advertisement->user->name}}
                                                        </a>
                                                    </div>
                                                    <div class="image">
                                                        <span class="place">
                                                            <i class="map marker icon"></i>{{$advertisement->place}}
                                                        </span>
                                                        @if(is_array($advertisement->image_path))
                                                            <img src="{{$advertisement->image_path[0]}}">
                                                        @else
                                                            <img src="{{$advertisement->image_path}}">
                                                        @endif
                                                    </div>
                                                    <div class="content">
                                                        <div class="right floated">
                                                            <div class="ui star rating read" data-rating="{{$advertisement->rate}}" data-max-rating="5"></div>
                                                        </div>
                                                        <span class="left floated">
                                                            <i class="comment icon"></i>
                                                             {{$advertisement->comments->count()}} @lang('site.comments')
                                                        </span>
                                                    </div>
                                                    <div class="content">
                                                        <div class="right floated">{{$advertisement->price}} @lang('site.egp')</div>
                                                        <a href="{{route('advertisements.show',$advertisement->id)}}" class="header left floated">{{$advertisement->name}}</a>
                                                        <div class="description">
                                                            {{$advertisement->short_description}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="text-center">
                                            <div class="d-inline-block">
                                                {{$advertisements->appends(request()->query())->links()}}
                                            </div>
                                        </div>
                                    @else
                                        <h2 class="m-5">@lang('site.no_data_found')</h2>
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    @if($ended_advertisements->count())
                                        <div class="warning message">asda</div>
                                        <div class="ui stackable cards m-0">
                                            @foreach($ended_advertisements as $ended_advertisement)
                                                <div class="ui card">
                                                    {{--<a class="ui red ribbon label">Not Available</a>--}}
                                                    <div class="content">
                                                        <span class="meta right floated">{{$ended_advertisement->time_ago}}</span>
                                                        <a href="{{route('users.profile',$ended_advertisement->user->id)}}" class="left floated">
                                                            <img class="ui avatar image" src="{{$ended_advertisement->user->image_path}}"> {{$ended_advertisement->user->name}}
                                                        </a>
                                                    </div>
                                                    <div class="image">
                                                        <span class="place">
                                                            <i class="map marker icon"></i>Sharqyah
                                                        </span>
                                                        @if(is_array($ended_advertisement->image_path))
                                                            <img src="{{$ended_advertisement->image_path[0]}}">
                                                        @else
                                                            <img src="{{$ended_advertisement->image_path}}">
                                                        @endif
                                                    </div>
                                                    <div class="content">
                                                        <div class="right floated">
                                                            <div class="ui star rating read" data-rating="{{$ended_advertisement->rate}}" data-max-rating="5"></div>
                                                        </div>
                                                        <span class="left floated">
                                                            <i class="comment icon"></i>
                                                            {{$ended_advertisement->comments->count()}} @lang('site.comments')
                                                        </span>
                                                    </div>
                                                    <div class="content">
                                                        <div class="right floated">{{$ended_advertisement->price}} @lang('site.egp')</div>
                                                        <a href="{{route('advertisements.show',$ended_advertisement->id)}}" class="header left floated">{{$ended_advertisement->name}}</a>
                                                        <div class="description">
                                                            {{$ended_advertisement->short_description}}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="text-center">
                                            <div class="d-inline-block">
                                                {{$ended_advertisements->appends(request()->query())->links()}}
                                            </div>
                                        </div>
                                    @else
                                        <h2 class="m-5">@lang('site.no_data_found')</h2>
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection