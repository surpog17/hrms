<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    //
    protected $fillable = ['acc_id','name','date','from','to','active','for','remark'];
}
