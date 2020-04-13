<div class="comment my-comment" id="my-comment">
    <a class="avatar">
        <img src="{{auth()->user()->image_path}}">
    </a>
    <div class="content">
        <a class="author">{{auth()->user()->name}}</a>
        <div class="metadata">
            <span class="date">{{$comment->time_ago}}</span>
            <div id="rate-comment" class="ui star rating read" data-rating="{{$comment->rate}}" data-max-rating="5"></div>

            {{--<div id="rate-comment" class="ui star rating read" data-rating="{{$comment->rate}}" data-max-rating="5"></div>--}}
        </div>
        <div class="tools d-inline-block float-right">
            <span id="edit-comment"><i class="fa fa-edit text-blue"></i></span>
            <span id="delete-comment"><i class="fa fa-trash-alt text-danger"></i></span>
        </div>
        <input type="hidden" value="{{$comment->id}}" id="id-comment">
        <div class="text">
            <div class="field">
                <textarea class="w-100 mb-2" style="display: none" id="text-comment">{{$comment->comment}}</textarea>
                <div class="btn btn-info" style="display: none" id="update-comment">@lang('site.update')</div>
            </div>
            <div id="old-comment">{{$comment->comment}}</div>
        </div>
    </div>
</div>
<script>
    $('.ui.rating.read')
    .rating('disable');
</script>