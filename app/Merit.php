<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merit extends Model
{
    //
    protected $fillable = ['name','date','warn','remark','active','merit_type_id','employee_id', 'amount_type', 'type', 'value','vp'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function meritType()
    {
        return $this->belongsTo('App\MeritType');
    }
}
