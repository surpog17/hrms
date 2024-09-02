<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raw extends Model
{
    //
    protected $fillable = ['acc_id','name','date','morning','afternoon','check_in','check_out'];
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
    public function webhr()
    {
        return $this->belongsTo('App\Webhr','acc_id','acc_id');
    }
}
