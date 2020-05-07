<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image','birth_date'
    ];
    protected $appends =[
        'image_path'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getImagePathAttribute()
    {
        return asset('uploads/user_images/'.$this->image);
    }
    // Relations
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
    public function socialaccount()
    {
        return $this->hasOne(SocialAccount::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function talkedTo()
    {
        return $this->hasMany(Message::class,'from');
    }

    public function relatedTo()
    {
        return $this->hasMany(Message::class,'to');
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
