<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Morning extends Model
{
    //
    protected $fillable = ['calculated_id','date','late','active'];

    public function calculated()
    {
        return $this->belongsTo('App\Calculated');
    }
}
