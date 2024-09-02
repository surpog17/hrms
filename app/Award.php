<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    //
    protected $fillable = ['employee_id','bonus','allowance','ieb','eodb','cdb','mpeqb','speqb','tvcqb','bepeqb','fhaqb','tpcqb','exam_bonus','active', 'position_allowance','cashcollection','operationleadership','adminincentive','operationincentive'];

    public function employee(){
        return $this->belongsTo('App\Employee');
    }
}
