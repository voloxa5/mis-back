<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShiftInstruction extends Model
{
    protected $fillable = array(
        'employee_id',
        'shift_id'
    );

    public function actualEmployee()
    {
        return $this->hasOne(ActualEmployee::class, 'id');
    }

    public function shift()
    {
        return $this->hasOne(Shift::class, 'id');
    }
}

