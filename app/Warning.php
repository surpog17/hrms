<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    //
    protected $fillable = ['acc_id','name','date','employee_id','type_id','warn','remark','action','active','excuse'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
    public function type()
    {
        return $this->belongsTo('App\Type');
    }
}
