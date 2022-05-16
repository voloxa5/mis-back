<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = array(
        'number',
        'start_time',
        'end_time',
        'was_observed_id',
        'supervision_condition',
        'supervision_id'
    );

    public function supervision()
    {
        return $this->hasOne(Supervision::class, 'id');
    }

    public function wasObserved()
    {
        return $this->hasOne(DictYesNo::class, 'id', 'was_observed_id');
    }

    public function instructions()
    {
        return $this->hasMany(ShiftInstruction::class);
    }
}

