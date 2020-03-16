<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\SocialAccount;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($Provider)
    {
        return Socialite::driver($Provider)->redirect();
    }

    public function handleProviderCallback($Provider)
    {
        $provider= Socialite::driver($Provider)->stateless()->user();
        $chkAccount= SocialAccount::where('provider',$Provider)
            ->where('provider_user_id',$provider->getId())->first();
        if ($chkAccount)
        {
            $user=$chkAccount->user;
        }
        else
        {
            $account= new SocialAccount([
                'provider_user_id'=>$provider->getId(),
                'provider'=>$Provider
            ]);
            //check if email of this social not matching with another social account
            $chkEmail= User::where('email',$provider->getEmail())->first();
            if (!$chkEmail)
            {
                $image=$provider->getId().'.jpg';
                $user=User::create([
                    'name'=>$provider->getName(),
                    'email'=>$provider->getEmail(),
                    'password'=>'',
                    'image'=>$image
                ]);

                $fileContents = file_get_contents($provider->getAvatar());
                File::put(public_path('uploads/user_images/'). $provider->getId() . ".jpg", $fileContents);
                $account->user()->associate($user);
                $account->save();
                $user->attachRole('user');
            }
        }
        auth()->login($user);
        return redirect()->to(RouteServiceProvider::HOME);
    }
}
