<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Supervision extends Model
{
    protected $fillable = array(
        'task_id',
        'start_date',
        'end_date',
        'content'
    );

    public function task()
    {
        return $this->hasOne(Task::class, 'id');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'id');
    }
}
