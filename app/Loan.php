<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    protected $fillable = ['total_amount', 'paid_amount', 'current_amount', 'remaining_amount', 'date', 'employee_id', 'category_id', 'duration'];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
