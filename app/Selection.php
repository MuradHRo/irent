<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $fillable=[
      'name','selector_id'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
