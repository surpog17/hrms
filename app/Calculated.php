<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calculated extends Model
{
    //
    protected $fillable = ['acc_id', 'name', 'total_late', 'total_overtime', 'morning_ovetime', 'morning_late', 'afternoon_overtime', 'lunch_late', 'afternoon_early', 'weekend_overtime','from','to','active'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function morning()
    {
        return $this->hasMany('App\Morning');
    }

}
