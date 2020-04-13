@foreach($messages as $message)
    @if($message->from == auth()->user()->id)
        <!-- Message to the right -->
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
        <!-- /.direct-chat-msg -->
    @else
        <!-- Message. Default to the left -->
        <div class="direct-chat-msg">
            <div class="direct-chat-infos clearfix">
                <span class="direct-chat-name float-left">{{$message->sender->name}}</span>
                <span class="direct-chat-timestamp float-right">{{$message->time_ago}}</span>
            </div>
            <!-- /.direct-chat-infos -->
            <img class="direct-chat-img" src="{{$message->sender->image_path}}" alt="message user image">
            <!-- /.direct-chat-img -->
            <div class="direct-chat-text">
                {{$message->message}}
            </div>
            <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->
    @endif
@endforeach