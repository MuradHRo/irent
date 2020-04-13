<div class="direct-chat-msg right">
    <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name float-right">{{auth()->user()->name}}</span>
        <span class="direct-chat-timestamp float-left">{{$message->time_ago}}</span>
    </div>
    <!-- /.direct-chat-infos -->
    <img class="direct-chat-img" src="{{auth()->user()->image_path}}" alt="message user image">
    <!-- /.direct-chat-img -->
    <div class="direct-chat-text">
        {{$message->message}}
    </div>
    <!-- /.direct-chat-text -->
</div>