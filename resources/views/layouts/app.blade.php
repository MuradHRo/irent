<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('uploads/i rent logo 2.1-01.png')}}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlte.min.css')}}">
    <!-- Toaster -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/toastr/toastr.min.css')}}">
    <!-- Semantic UI -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/semantic-ui/semantic.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/summernote/summernote-bs4.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('dashboard/plugins/select2/css/select2.min.css')}}">
    {{--CSS--}}
    <link rel="stylesheet" href="{{asset('dashboard/plugins/style.css')}}">
    @if(app()->getLocale()=='en')
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @else
            <link rel="stylesheet" href="{{asset('dashboard/rtl/dist/css/custom.css')}}">
            <!-- Google Font: Source Sans Pro -->
            <link href="https://fonts.googleapis.com/css?family=Cairo:300,700" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">

    @endif
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">

    @include('layouts.dashboard._navbar')

    @include('layouts._aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if(auth()->user())
        <div class="card direct-chat direct-chat-primary collapsed-card">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">@lang('site.chat')</h3>

                <div class="card-tools">
                    <span id="num_un_read" data-toggle="tooltip" class="badge badge-primary">0</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                        @php
                            session_start();
                        @endphp
                    @if(isset($_SESSION['receiver_id']))
                        @php
                            $user_id= $_SESSION['receiver_id'];
                            $my_id= auth()->user()->id;
                            $messages=\App\Message::where(function ($query) use ($user_id,$my_id){
                                $query->where('from',$my_id)->where('to',$user_id);
                            })->orWhere(function ($query) use ($user_id,$my_id){
                                $query->where('to',$my_id)->where('from',$user_id);
                            })->get();
                            $un_read_msgs= \App\Message::where('to',$my_id)->where('from',$user_id)->where('is_read',0)->get();
                            foreach ($un_read_msgs as $msg)
                            {
                                $msg->update([
                                    'is_read'=>1
                                ]);
                            }
                        @endphp
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
                    @endif
                </div>
                <!--/.direct-chat-messages-->

                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                    <ul class="contacts-list">

                        <!-- End Contact Item -->
                    </ul>
                    <!-- /.contacts-list -->
                </div>
                <!-- /.direct-chat-pane -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="input-group">
                    <input type="text" name="message" placeholder="@lang('site.type_message')" class="form-control message-text">
                    <span class="input-group-append">
                    <button id="message-send" type="button" class="btn btn-primary">@lang('site.send')</button>
                </span>
                </div>
            </div>
            <!-- /.card-footer-->
        </div>
        @endif
        @yield('content')
        @yield('footer')
    </div>

    <!-- /.content-wrapper -->
    {{--<footer class="main-footer">--}}
        {{--<strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>--}}
        {{--All rights reserved.--}}
        {{--<div class="float-right d-none d-sm-inline-block">--}}
            {{--<b>Version</b> 3.0.2--}}
        {{--</div>--}}
    {{--</footer>--}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('dashboard/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('dashboard/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);

</script>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('dashboard/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('dashboard/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('dashboard/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('dashboard/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('dashboard/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('dashboard/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dashboard/dist/js/adminlte.js')}}"></script>
<!-- Toaster -->
<script src="{{asset('dashboard/plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dashboard/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dashboard/dist/js/demo.js')}}"></script>
{{--Check Editeor--}}
<script src="{{asset('dashboard/plugins/ckeditor/ckeditor.js')}}"></script>
{{--Print This--}}
<script src="{{asset('dashboard/plugins/printThis.js')}}"></script>
{{--Select 2--}}
<script src="{{asset('dashboard/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Semantic UI -->
<script src="{{asset('dashboard/plugins/semantic-ui/semantic.min.js')}}"></script>
<!--Algolia places-->
<script src="https://cdn.jsdelivr.net/npm/places.js@1.18.1"></script>
    {{-- Custom Java script--}}
                            {{--Selection--}}
<script src="{{asset('dashboard/dist/js/custom/selections.js')}}"></script>
                            {{--Advertisements--}}
<script src="{{asset('dashboard/dist/js/custom/advertisements.js')}}"></script>

@include('partials._session')
<script>
    {{--Start Image Preview--}}
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function() {
        readURL(this);
    });
//    End Image Preview
//    select2 Initialize
    $('.select2').select2({
        placeholder: '@lang('site.choose_questions')',
    });
//    Check Editor Initialize
    CKEDITOR.config.language="{{app()->getLocale()}}";
//    rating initializing
    $('.ui.rating')
        .rating({
            initialRating: 0,
            maxRating: 5
        })
    ;
//    Modal
    $('.ui.modal')
        .modal()
    ;
//    Dropdown
    $('.ui.dropdown')
        .dropdown()
    ;
//    algolia
    var placesAutocomplete = places({
        appId: 'plS3G90OFYMT',
        apiKey: 'eee42fc88bbf3a54000ddec6e11037f6',
        container: document.querySelector('#address-input'),
        countries: ['eg'], // Search in the United States of America and in the Russian Federation
        type: 'city', // Search only for cities names
        aroundLatLngViaIP: false // disable the extra search/boost around the source IP
    });

</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var  receiver_id ='{{isset($_SESSION['receiver_id'])?$_SESSION['receiver_id']:''}}';
    $(document).ready(function () {
        $(document).on('keyup','.message-text',function (e) {
            var message= $(this).val();
            if (e.keyCode == 13 && message.trim()!='' && receiver_id!='')
            {
                $(this).val('');
                $.ajax({
                    type:'GET',
                    url:'/message',
                    data:{'receiver_id':receiver_id,'message':message},
                    success:function (data) {
                        var d =$('.direct-chat-messages');
                        d.append(data);
                        d.scrollTop(d.prop("scrollHeight"));
                    },
                    complete:function () {
                        
                    }
                });
            }
        });
        $(document).on('click','#message-send',function () {
            var message= $('.message-text').val();
            if (message.trim()!='' && receiver_id!='')
            {
                $('.message-text').val('');
                $.ajax({
                    type:'GET',
                    url:'/message',
                    data:{'receiver_id':receiver_id,'message':message},
                    success:function (data) {
                        var d =$('.direct-chat-messages');
                        d.append(data);
                        d.scrollTop(d.prop("scrollHeight"));
                    },
                    complete:function () {

                    }
                });
            }
        });
        $.ajax({
            type:'GET',
            url:'/message/getUsers',
            success:function (data) {
                $('.contacts-list').append(data);
            },
            complete:function () {

            }
        });
        //Get Messages
        $(document).on('click','.contact',function () {
            receiver_id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:'/message/getMessages',
                data:{'user_id':receiver_id},
                success:function (data) {
                    $('.direct-chat').removeClass('collapsed-card');
                    var d =$('.direct-chat-messages');
                    d.html(data);
                    d.scrollTop(d.prop("scrollHeight"));
                    $('.card.direct-chat').removeClass('direct-chat-contacts-open');
                }
            })
        });


    });
</script>
    {{--SSE--}}
@if(auth()->user())
    <script>
        $(document).ready(function () {
            //    SSE
            var d =$('.direct-chat-messages');
            let evtActivity = new EventSource("/SSE", {withCredentials: true});

            evtActivity.onmessage = function(event) {

                var data = JSON.parse(event.data);
                // Number of unread_messages
                $('#num_un_read').html(data.unread_messages);

                // Show New Messages
                d.append(data.new_messages);
                d.scrollTop(d.prop("scrollHeight"));

                // Show new messages from other users
                $('.contacts-list').html(data.users);

            };
            evtActivity.onopen = function(){
                // console.log('connection is opened.'+evtActivity.readyState);
            };

            evtActivity.onerror = function(event){
                // console.log(event)
            };
        });
    </script>
@endif
</body>
</html>
