<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduct extends Model
{
    //
    protected $fillable = ['employee_id','employee_name','medical','absent','other','loan','pma','car','exam','latecommer','active'];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
