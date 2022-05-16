<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed month
 * @property mixed year
 * @property mixed employees_unit_id
 * @property mixed ratifying_id
 * @property mixed ratifying_post_id
 * @property mixed ratifying_rank_id
 * @property mixed performer_id
 * @property mixed performer_post_id
 * @property mixed performer_rank_id
 */
class TimeSheet extends Model
{
    protected $fillable = array(
        'id',
        'month',
        'year',
        'employees_unit_id',
        'ratifying_id',
        'ratifying_post_id',
        'ratifying_rank_id',
        'performer_id',
        'performer_post_id',
        'performer_rank_id',
    );

    public function timeSheetEmployees()
    {
        return $this->hasMany(TimeSheetEmployee::class)->orderBy('surname');
    }

    public function timeSheetNonworkingOrders()
    {
        return $this->hasMany(TimeSheetNonworkingOrder::class);
    }

    public function document()
    {
        return $this->hasOne(Document::class, 'domain_id', 'id');
    }

    public function employeesUnit()
    {
        return $this->hasOne(EmployeesUnit::class, 'id', 'employees_unit_id');
    }

    public function ratifying()
    {
        return $this->hasOne(Employee::class, 'id', 'ratifying_id');
    }

    public function ratifyingPost()
    {
        return $this->hasOne(DictPost::class, 'id', 'ratifying_post_id');
    }

    public function ratifyingRank()
    {
        return $this->hasOne(DictRank::class, 'id', 'ratifying_rank_id');
    }

    public function performer()
    {
        return $this->hasOne(Employee::class, 'id', 'performer_id');
    }

    public function performerPost()
    {
        return $this->hasOne(DictPost::class, 'id', 'performer_post_id');
    }

    public function performerRank()
    {
        return $this->hasOne(DictRank::class, 'id', 'performer_rank_id');
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['month'])) {
            $query->where('month', $params['month']['o'], $params['month']['v']);
        }
        if (isset($params['year'])) {
            $query->where('year', $params['year']['o'], $params['year']['v']);
        }
        if (isset($params['employees_unit_id'])) {
            $query->where('employees_unit_id', $params['employees_unit_id']['o'], $params['employees_unit_id']['v']);
        }

        return $query;
    }
}
