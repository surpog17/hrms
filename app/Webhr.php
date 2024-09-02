<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webhr extends Model
{
    //

        protected $fillable = ['webhr_id', 'full_name', 'acc_id', 'user_name', 'email', 'designation', 'type', 'department', 'status', 'phone_no', 'address', 'dob', 'machine_id', 'joining_date'];


    public function raw()
    {
        return $this->hasMany('App\Raw','acc_id','acc_id');
    }

}
