<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebhrLate extends Model
{
    //
    protected $fillable = ['employee_id','date','late','validated', 'lunch_late','type'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
