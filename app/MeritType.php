<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeritType extends Model
{
    //
    protected $fillable = ['name'];

    public function merit()
    {
        return $this->hasOne('App\Merit');
    }
}
