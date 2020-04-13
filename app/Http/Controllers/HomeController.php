<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Events\MyEvent;
use App\Message;
use App\Subcategory;
use Illuminate\Http\Request;
use Pusher\Pusher;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sub_categories = Subcategory::all();
        $last_ads = Advertisement::orderBy('created_at')->take(10)->get();
        return view('index',compact('last_ads','sub_categories'));
    }
    public function sendMessage(Request $request)
    {
        session_start();
        $_SESSION['receiver_id']=$request->receiver_id;
        $request->validate([
            'receiver_id'=>'required',
            'message'=>'required'
        ]);
        $from = auth()->user()->id;
        $to = $request->receiver_id;
        $message_text = $request->message;

        $message = Message::create([
            'from'=>$from,
            'to'=>$to,
            'message'=>$message_text,
            'is_read'=>0
        ]);
        return view('messages._new',compact('message'));
    }
    public function getUsers()
    {
        $talked_to = auth()->user()->talkedTo()->latest();
        $all = auth()->user()->relatedTo()->latest()->union($talked_to)->orderBy('created_at','desc')->get();
        $unique_ids = array();
        $unique = array();
        foreach ($all as $one)
        {
            if($one['from'] == auth()->user()->id)
            {
                if (!in_array($one['to'],$unique_ids))
                {
                    $unique_ids[]= $one['to'];
                    $unique[]=$one;
                }
            }
            else
            {
                if (!in_array($one['from'],$unique_ids))
                {
                    $unique_ids[]=$one['from'];
                    $unique[]=$one;
                }
            }
        }
        return view('messages._users',compact('unique'));
    }
    public function getMessages(Request $request)
    {
        session_start();
        $_SESSION['receiver_id']=$request->user_id;
        $request->validate([
            'user_id'=>'required'
        ]);
        $user_id= $request->user_id;
        $my_id= auth()->user()->id;
        $messages= Message::where(function ($query) use ($user_id,$my_id){
            $query->where('from',$my_id)->where('to',$user_id);
        })->orWhere(function ($query) use ($user_id,$my_id){
            $query->where('to',$my_id)->where('from',$user_id);
        })->get();
        $un_read_msgs= Message::where('to',$my_id)->where('from',$user_id)->where('is_read',0)->get();
        foreach ($un_read_msgs as $msg)
        {
            $msg->update([
                'is_read'=>1
            ]);
        }
        return view('messages._messages',compact('messages'));
    }
    public function SSE(Request $request)
    {
//        Get UnReadMessages
        $data['unread_messages'] = auth()->user()->relatedTo()->where('is_read',0)->count();

//        Get New Messages
        session_start();
        if (isset($_SESSION['receiver_id']))
        {
            $new_messages = auth()->user()->relatedTo()->where('from',$_SESSION['receiver_id'])->where('is_read',0)->get();
            $new_messages_view='';
            foreach ($new_messages as $message)
            {
                $message->update(['is_read'=>1]);
                $new_messages_view .=
                    '<div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">'.$message->sender->name.'</span>
                            <span class="direct-chat-timestamp float-right">'.$message->time_ago.'</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="'.$message->sender->image_path.'" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            '.$message->message.'
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>';
            }
            $data['new_messages']=$new_messages_view;
        }
//      Get Users
        $get_users_view='';
        $talked_to = auth()->user()->talkedTo()->latest();
        $all = auth()->user()->relatedTo()->latest()->union($talked_to)->orderBy('created_at','desc')->get();
        $unique_ids = array();
        $unique = array();
        foreach ($all as $one)
        {
            if($one['from'] == auth()->user()->id)
            {
                if (!in_array($one['to'],$unique_ids))
                {
                    $unique_ids[]= $one['to'];
                    $unique[]=$one;
                }
            }
            else
            {
                if (!in_array($one['from'],$unique_ids))
                {
                    $unique_ids[]=$one['from'];
                    $unique[]=$one;
                }
            }
        }
        foreach($unique as $one)
        {
            if (auth()->user()->id == $one->from)
            {
                $data_id =$one->receiver->id;
                $img= '<img class="contacts-list-img" src="'.$one->receiver->image_path.'">';
                $name = $one->receiver->name;
            }
            else
            {
                $data_id=$one->sender->id;
                $img =  '<img class="contacts-list-img" src="'.$one->sender->image_path.'">';
                $name = $one->sender->name;
            }
            $get_users_view .='
                    <li style="cursor:pointer" class="contact" data-id="'.$data_id.'">
                        <a>
                            '.$img.'
                            <div class="contacts-list-info">
                                          <span class="contacts-list-name">
                                            '.$name.'
                                            <small class="contacts-list-date float-right">'.$one->time_ago.'</small>
                                          </span>
                                <span class="contacts-list-msg">'.$one->message.'</span>
                            </div>
                            <!-- /.contacts-list-info -->
                        </a>
                    </li>';
        }
        $data['users']=$get_users_view;
//
        $response = new StreamedResponse();
        $response->setCallback(function () use ($data){

            echo 'data: ' . json_encode($data) . "\n\n";
            ob_flush();
            flush();
            sleep(4);
//            usleep(200000);
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        $response->send();
    }
}
