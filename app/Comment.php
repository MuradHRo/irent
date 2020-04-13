<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
        'rate','comment','user_id','advertisement_id'
    ];
    protected $appends=[
      'time_ago'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function getTimeAgoAttribute()
    {
        $time = strtotime($this->created_at);
        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        if (app()->getLocale() == 'en') {
            $tokens = array(
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second'
            );
            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
            }
        } else {
            $tokens = array(
                31536000 => 'سنه',
                2592000 => 'شهر',
                604800 => 'اسبوع',
                86400 => 'يوم',
                3600 => 'ساعه',
                60 => 'دقيقه',
                1 => 'ثانيه'
            );
            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return 'منذ' . ' ' . $numberOfUnits . ' ' . $text;
            }
        }
    }
}
