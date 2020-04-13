<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;
//    public $timestamps=true;
    protected $fillable=[
        'name','short_description','image','price','price_per','available_at','place','user_id','subcategory_id','created_at'
    ];
    protected $appends =[
        'image_path','time_ago','rate','trashed_at','force_deleted_at','price_per_x','available_status','available_time','check_weight'
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
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function getImagePathAttribute()
    {
        if (strpos($this->image,','))
        {
            $images= explode(',', $this->image);
            foreach ($images as $image)
            {
                $image_path[] = asset('uploads/advertisement_images/'.$image);
            }
            return $image_path;
        }
        else
        {
            return asset('uploads/advertisement_images/'.$this->image);
        }
    }
    public function getTimeAgoAttribute()
    {
        $time=strtotime($this->created_at);
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        if (app()->getLocale()=='en') {
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
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
            }
        }
        else
        {
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
                return 'منذ'.' '.$numberOfUnits.' '.$text;
            }
        }
    }
    public function getRateAttribute()
    {
        $sum=$this->comments()->sum('rate');
        $count=$this->comments()->count();

        return $count>0? round($sum/$count) : 0;
    }
    public function getTrashedAtAttribute()
    {
        $trashed_at= $this->created_at;
        date_add($trashed_at, date_interval_create_from_date_string('30 days'));
        return $trashed_at;
    }
    public function getForceDeletedAtAttribute()
    {
        $force_deleted_at= $this->deleted_at;
        date_add($force_deleted_at, date_interval_create_from_date_string('7 days'));
        return $force_deleted_at;
    }
    public function getPricePerXAttribute()
    {
        if (app()->getLocale()=='en') {
            $price_per=array(
                '0'=>'Per Weak',
                '1'=>'Per Month',
                '2'=>'Per Year'
            );
        }
        else
        {
            $price_per=array(
                '0'=>'لكل اسبوع',
                '1'=>'لكل شهر',
                '2'=>'لكل سنه'
            );
        }
        return $price_per[$this->price_per];
    }
    public function getAvailableStatusAttribute()
    {
        if ($this->available_at > now())
        {
            return false;
        }
        return true;
    }
    public function getCheckWeightAttribute()
    {
        $max_reports = $this->user->user_weight * 20;
        if ($this->reports()->count() >= $max_reports)
        {
            return true;
        }
        return false;
    }
    public function getAvailableTimeAttribute()
    {
        $time=strtotime($this->available_at);
        $time = $time - time(); // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        if (app()->getLocale()=='en') {
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
                return 'Available After '. $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
            }
        }
        else
        {
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
                return 'متاح بعد'.' '.$numberOfUnits.' '.$text;
            }
        }
    }
}
