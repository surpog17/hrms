<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebhrAbsent extends Model
{
    //
    protected $fillable = ['employee_id','date','validated'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
