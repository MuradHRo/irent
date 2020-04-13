<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(User $user)
    {
        $advertisements = $user->advertisements()->paginate(5);
        $ended_advertisements= $user->advertisements()->onlyTrashed()->paginate(5);
        return view('users.profile',compact('user','advertisements','ended_advertisements'));
    }
}
