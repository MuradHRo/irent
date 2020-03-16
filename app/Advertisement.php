<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable=[
        'name','image','price','user_id','subcategory_id'
    ];
    protected $appends =[
        'image_path'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function getImagePathAttribute()
    {
        return asset('uploads/advertisement_images/'.$this->image);
    }
}
