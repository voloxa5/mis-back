<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed name
 * @property mixed surname
 * @property mixed patronymic
 * @property mixed callsign
 * @property mixed post_id
 * @property mixed rank_id
 * @property mixed working_id
 * @property mixed sex_id
 * @property mixed dob
 * @property mixed user_id
 * @property mixed employees_unit_id
 */
class Employee extends Model
{
    protected $fillable = array(
        'name',
        'surname',
        'patronymic',
        'callsign',
        'post_id',
        'rank_id',
        'working_id',
        'sex_id',
        'dob',
        'user_id',
        'employees_unit_id',
    );

    public function employeesUnit()
    {
        return $this->hasOne(EmployeesUnit::class, 'id', 'employees_unit_id');
    }

    public function post()
    {
        return $this->hasOne(DictPost::class, 'id', 'post_id');
    }

    public function rank()
    {
        return $this->hasOne(DictRank::class, 'id', 'rank_id');
    }

    public function working()
    {
        return $this->hasOne(DictYesNo::class, 'id', 'working_id');
    }

    public function sex()
    {
        return $this->hasOne(DictSex::class, 'id', 'sex_id');
    }

    public function assignmentRanks()
    {
        return $this->hasMany(AssignmentRank::class, 'id');
    }

    public function assignmentPosts()
    {
        return $this->hasMany(AssignmentPost::class, 'id');
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['non_linked'])) {
            $query->whereNotExists(function ($query2) use ($params) {
                $query2->select(DB::raw(1))
                    ->from('users')
                    ->whereRaw('users.id = employees.user_id');
            });
        }
    }
}
