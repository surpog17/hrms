<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //

    protected $fillable = ['acc_id','full_name', 'first_name', 'last_name', 'is_manager', 'is_driver','basic_salary','probation' ,'is_active', 'calculated_id', 'joining_date', 'medical_insurance'];
    public function raw()
    {
        return $this->hasMany('App\Raw');
    }

    public function calculated()
    {
        return $this->hasMany('App\Calculated');
    }

    public function warning()
    {
        return $this->hasMany('App\Warning');
    }

    public function loan()
    {
        return $this->hasMany('App\Loan');
    }
    public function registered()
    {
        return $this->hasMany('App\RegisteredAbsent');
    }
    public function merit()
    {
        return $this->hasMany('App\Merit');
    }

    public function webhrabsent()
    {
        return $this->hasMany('App\WebhrAbsent');
    }

    public function webhrlate()
    {
        return $this->hasMany('App\WebhrLate');
    }

    public function newresign()
    {
        return $this->hasOne('App\NewResign');
    }

    public function payroll(){
        return $this->hasOne('App\Payroll');
    }


}
