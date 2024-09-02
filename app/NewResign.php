<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewResign extends Model
{
    //
    protected $fillable = ['employee_id','date','remark'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
