<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActualEmployee extends Model
{
    protected $fillable = array(
        'name',
        'surname',
        'patronymic',
        'callsign',
        'post_id',
        'rank_id',
        'working_id',
        'employee_id'
    );

    public function post()
    {
        return $this->hasOne(DictPost::class, 'id');
    }

    public function rank()
    {
        return $this->hasOne(DictRank::class, 'id');
    }

    public function working()
    {
        return $this->hasOne(DictYesNo::class, 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id');
    }

}
