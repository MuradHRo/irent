<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_admins'])->only('index');
        $this->middleware(['permission:create_admins'])->only('create','store');
        $this->middleware(['permission:update_admins'])->only('update','edit');
        $this->middleware(['permission:delete_admins'])->only('destroy');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->where(function ($q)use ($request){
            return $q->when($request->search,function ($query)use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(2);
        return view('dashboard.admins.index',compact('users'));
    }//end of index
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admins.create');
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
            'permissions'=>'required|min:1'
        ]);
        $request_data= $request->except('password','password_confirmation','permissions','image');
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
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.admins.index');
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
    public function edit($user_id)
    {
        $user=User::FindOrfail($user_id);
        return view('dashboard.admins.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $user=User::FindOrfail($user_id);
        $request->validate([
            'name'=>'required|min:1',
            'email'=>['required',Rule::unique('users')->ignore($user->id)],
            'image'=>'image',
            'permissions'=>'required|min:1'
        ]);
        $request_data= $request->except('permissions','image');
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
        $user->syncPermissions($request->permissions);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.admins.index');
    }//end of update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $user=User::FindOrfail($user_id);
        if ($user->image != 'default.png')
        {
            Storage::disk('public_uploads')->delete('/user_images/'.$user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.admins.index');
    }
}
