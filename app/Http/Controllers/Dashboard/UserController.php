<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create','store');
        $this->middleware(['permission:update_users'])->only('update','edit');
        $this->middleware(['permission:delete_users'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::whereRoleIs('user')->where(function ($q)use ($request){
            return $q->when($request->search,function ($query)use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(5);
        return view('dashboard.users.index',compact('users'));
    }//end of index
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.users.create');
    }//end of create

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:1',
            'email'=>'required|unique:users',
            'image'=>'image',
            'password'=>'required|confirmed',
        ]);
        $request_data= $request->except('password','password_confirmation','image');
        $request_data['password']=bcrypt($request->password);
        if ($request->image)
        {
            Image::make($request->image)->resize(300, null, function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/'.$request->image->hashName()));
            // hashName = make name unique to prevent duplication
            $request_data['image']=$request->image->hashName();
        }//end of if
        $user=User::create($request_data);
        $user->attachRole('user');
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }//end of store

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
//    public function show(User $user)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=>'required|min:1',
            'email'=>['required',Rule::unique('users')->ignore($user->id)],
            'image'=>'image',
        ]);
        $request_data= $request->except('image');
        if ($request->image)
        {
            if($request->image != 'default.png')
            {
                if ($user->image != 'default.png')
                {
                    Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
                }
                Image::make($request->image)->resize(300, null, function ($constraint){
                    $constraint->aspectRatio();
                })->save(public_path('uploads/user_images/'.$request->image->hashName()));
                // hashName = make name unique to prevent duplication
                $request_data['image']=$request->image->hashName();

            }
        }//end of if
        $user->update($request_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }//end of update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image != 'default.png')
        {
            Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
