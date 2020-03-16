<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable=[
        'name','category_id','icon'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
