@extends('layouts.app')
@section('content')
<section class="content">
    <div class="ui modal mini delete-comment">
        <i class="close icon"></i>
        <div class="header">
            @lang('site.confirm')
        </div>
        <div class="content">
            @lang('site.delete_comment?')
        </div>
        <div class="actions">
            <div class="ui red deny button">
                @lang('site.no')
            </div>
            <div class="ui positive right labeled icon button">
                @lang('site.yes')
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>
    <div class="ui modal mini mark_unavailable_advertisement">
        <i class="close icon"></i>
        <div class="header">
            @lang('site.mark_as_unavailable')
        </div>
        <form style="width: 100%;padding: 5px 10px;margin-top: 10px;" class="d-inline-block" action="{{ route('advertisements.mark_unavailable' , $advertisement->id)}}" method="POST">
        <div class="content">
            <input type="date" name="available_at" required>
            {{ csrf_field() }}
        </div>
        <div class="actions" style="margin-top: 10px;text-align: right;">
                <button type="submit" class="ui positive right labeled icon button">
                    @lang('site.mark')
                    <i class="checkmark icon"></i>
                </button>
        </div>
        </form>
    </div>
    <div class="ui modal mini delete-advertisement">
        <i class="close icon"></i>
        <div class="header">
            @lang('site.confirm')
        </div>
        <div class="content">
            @lang('site.delete_advertisement?')
        </div>
        <div class="actions">
            <div class="ui red deny button">
                @lang('site.no')
            </div>
            <form class="d-inline-block" action="{{ route('advertisements.destroy' , $advertisement->id)}}" method="POST">
                <input name="_method" type="hidden" value="DELETE">
                {{ csrf_field() }}
                <button type="submit" class="ui positive right labeled icon button">
                    @lang('site.yes')
                    <i class="checkmark icon"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- Default box -->
    <div class="card card-solid mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    {{--<h3 class="d-inline-block d-sm-none">{{$advertisement->name}}</h3>--}}
                    <div class="col-12">
                        @if(!$advertisement->available_status)
                            <a class="ui red ribbon label">{{$advertisement->available_time}}</a>
                        @endif
                        @if(is_array($advertisement->image_path))
                            <img src="{{$advertisement->image_path[0]}}" class="product-image" alt="Product Image" id="main-image">
                        @else
                            <img src="{{$advertisement->image_path}}" class="product-image" alt="Product Image">
                        @endif
                    </div>
                    <div class="col-12 product-image-thumbs">
                        @if(is_array($advertisement->image_path))
                            @foreach($advertisement->image_path as $image)
                                @if(!$loop->first)
                                    <div class="product-image-thumb">
                                        <img class="sub-image" src="{{$image}}" alt="Product Image">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div style="display: flow-root">
                        <div class="mb-0 ui header blue float-left">{{$advertisement->name}}</div>
                        <div class="float-right">
                            <div class="ui star rating read" data-rating="{{$advertisement->rate}}" data-max-rating="5"></div>
                            @if(auth()->user())
                            <div class="ui icon top left pointing dropdown">
                                <i class="ellipsis vertical icon"></i>
                                <div class="menu">
                                    @if(auth()->user()->owns($advertisement))
                                        @if($advertisement->trashed())
                                            <div class="item"><a style="color: black" href="{{route('advertisements.renew',$advertisement->id)}}">@lang('site.renew')</a></div>
                                        @endif
                                        @if($advertisement->available_status)
                                        <div class="item" id="mark_unavailable_advertisement">@lang('site.mark_as_unavailable')</div>
                                        @else
                                        <div class="item"><a style="color: black" href="{{route('advertisements.mark_available',$advertisement->id)}}">@lang('site.mark_as_available')</a></div>
                                        @endif
                                        <div class="item"><a style="color: black" href="{{route('advertisements.edit',$advertisement->id)}}">@lang('site.edit')</a></div>
                                        <div class="item" id="delete-advertisement">@lang('site.delete')</div>
                                    @else
                                        @if(!$advertisement->user->hasRole('super_admin')||$advertisement->user->hasRole('admin'))
                                            <div class="item"><a style="color: black" href="{{route('advertisements.report',$advertisement->id)}}">@lang('site.report')</a></div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div style="color: grey" class="mb-3">{{$advertisement->time_ago}}</div>
                    <p style="font-size: 29px;color: darkslategray;">{{$advertisement->short_description}}</p>

                    <h4 class="ui horizontal divider header">
                        <i class="bar chart icon"></i>
                        @lang('site.details')
                    </h4>

                    @if($advertisement->count())
                        <table class="ui definition table">
                            <tbody>
                            @foreach($advertisement->answers as $answer)
                                <tr>
                                    <td>{{$answer->question->question}}</td>
                                    @if($answer->question->selections->isEmpty())
                                        <td>{{$answer->text}}</td>
                                    @else
                                        <td>{{$answer->question->selections()->findOrFail($answer->selection_id)->name}}</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if($advertisement->comments->count())
                    <div class="ui small orange statistic">
                        <div class="value">
                            <i class="comment alternate outline icon"></i>{{$advertisement->comments->count()}}
                        </div>
                        <div class="label">
                            @lang('site.comments')
                        </div>
                    </div>
                    @endif
                    <div class="ui horizontal teal statistic">
                        <div class="value">
                            {{$advertisement->price}}
                        </div>
                        <div class="label">
                            @lang('site.egp') {{$advertisement->price_per_x}}
                        </div>
                    </div>
                    <hr>
                    {{--User--}}
                    @if(auth()->user() && !auth()->user()->owns($advertisement))
                    {{--<div class="card card-outline d-inline-block">--}}
                        {{--<div class="card-body box-profile">--}}
                            {{--<div class="float-left">--}}
                                {{--<div class="text-center">--}}
                                    {{--<img class="profile-user-img img-fluid img-circle" src="{{$advertisement->user->image_path}}" alt="User profile picture">--}}
                                {{--</div>--}}

                                {{--<h4 class="profile-username text-center">{{$advertisement->user->name}}</h4>--}}
                            {{--</div>--}}
                            {{--<a  data-id="{{$advertisement->user->id}}" style="cursor: pointer;color: white; margin-top: 40px;margin-left: 20px;" class="btn btn-primary float-right contact"><b>@lang('site.send_msg')</b></a>--}}
                        {{--</div>--}}
                        {{--<!-- /.card-body -->--}}
                    {{--</div>--}}
                        <div class="content">
                            <div class="float-left author">
                                <a href="{{route('users.profile',$advertisement->user->id)}}" style="color: black">
                                    <img class="ui avatar image" src="{{$advertisement->user->image_path}}"> {{$advertisement->user->name}}
                                </a>
                            </div>
                            <div class="float-right">
                                <button data-id="{{$advertisement->user->id}}" class="ui primary button contact tiny">@lang('site.send_msg')</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mt-4">
                <nav class="w-100">
                    <div class="nav nav-tabs" id="product-tab" role="tablist">
                        <a class="nav-item nav-link active" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">@lang('site.comments')</a>
                    </div>
                </nav>
                <div class="tab-content p-3 w-100" id="nav-tabContent">
                    <div class="tab-pane fade active show" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                        {{--Start of Comments--}}
                        <div class="ui large comments">
                            <div id="comments">
                                @foreach($advertisement->comments as $comment)
                                    @php
                                        $check_user = false;
                                        if (auth()->user())
                                        {
                                            if (auth()->user()->owns($comment))
                                            {
                                                $check_user = true;
                                            }
                                        }
                                    @endphp
                                <div class="comment {{$check_user?'my-comment':''}}" id="{{$check_user?'my-comment':''}}">
                                    <a class="avatar">
                                        <img src="{{$comment->user->image_path}}">
                                    </a>
                                    <div class="content">
                                        <a class="author">{{$comment->user->name}}</a>
                                        <div class="metadata">
                                            <span class="date">{{$comment->time_ago}}</span>
                                            <div id="{{$check_user?'rate-comment':''}}" class="ui star rating read" data-rating="{{$comment->rate}}" data-max-rating="5"></div>
                                        </div>
                                        @if($check_user)
                                            <div class="tools d-inline-block float-right">
                                                <span id="edit-comment"><i class="fa fa-edit text-blue"></i></span>
                                                <span id="delete-comment"><i class="fa fa-trash-alt text-danger"></i></span>
                                            </div>
                                            <input type="hidden" value="{{$comment->id}}" id="id-comment">
                                        @endif
                                        <div class="text">
                                            @if($check_user)
                                            <div class="field">
                                                <textarea class="w-100 mb-2" style="display: none" id="text-comment">{{$comment->comment}}</textarea>
                                                <div class="btn btn-info" style="display: none" id="update-comment">@lang('site.update')</div>
                                            </div>
                                            @endif
                                            <div id="{{$check_user?'old-comment':''}}">{{$comment->comment}}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(auth()->user() && !auth()->user()->owns($advertisement))
                                @if(!auth()->user()->comments()->where('advertisement_id',$advertisement->id)->count())
                                    <form class="ui reply form" id="form-comment">
                                        <div class="field">
                                            <textarea id="text-comment"></textarea>
                                        </div>
                                        <div class="ui star rating huge" id="rate-comment"></div>
                                        <input type="hidden" value="{{$advertisement->id}}" id="advertisement-comment">
                                        <div class="ui orange labeled submit icon button disabled" id="add-comment">
                                            <i class="icon edit"></i> @lang('site.add_comment')
                                        </div>
                                    </form>
                                @endif
                            @endif
                        </div>
                        {{--End of comments--}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
@endsection