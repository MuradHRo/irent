<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=[
      'question'
    ];
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }
    public function selections()
    {
        return $this->belongsToMany(Selection::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
