<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name','duration'];

    public function loan()
    {
        return $this->hasMany('App\Loan');
    }
}
