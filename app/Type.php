<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    protected $fillable = ['name'];

    public function warning()
    {
        return $this->hasMany('App\Warning');
    }
}
