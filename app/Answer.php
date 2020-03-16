<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable =[
      'text','selection_id','advertisement_id','question_id'
    ];
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
