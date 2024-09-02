<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredAbsent extends Model
{
    //
    protected $fillable = ['employee_id','date','from','to','active','for','remark','validated','google_id','attachment'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

}
