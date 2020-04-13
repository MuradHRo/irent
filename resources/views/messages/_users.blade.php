@php

@endphp
@foreach($unique as $one)
    <li style="cursor:pointer" class="contact" data-id="@if(auth()->user()->id == $one->from){{$one->receiver->id}}@else{{$one->sender->id}}@endif">
        <a>
            @if(auth()->user()->id == $one->from)
                <img class="contacts-list-img" src="{{$one->receiver->image_path}}">
            @else
                <img class="contacts-list-img" src="{{$one->sender->image_path}}">
            @endif
            <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            @if(auth()->user()->id == $one->from)
                                  {{$one->receiver->name}}
                              @else
                                  {{$one->sender->name}}
                              @endif
                            <small class="contacts-list-date float-right">{{$one->time_ago}}</small>
                          </span>
                <span class="contacts-list-msg">{{$one->message}}</span>
            </div>
            <!-- /.contacts-list-info -->
        </a>
    </li>
@endforeach
