<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed employee_id
 * @property mixed day
 * @property mixed month
 * @property mixed year
 * @property mixed explanatory_date
 * @property mixed code
 * @property mixed exposition_text
 * @property mixed from_time
 * @property mixed to_time
 * @property mixed employees_unit_id
 * @property mixed surname
 * @property mixed post_id
 * @property mixed rank_id
 */
class TimeSheetEmployee extends Model
{
    protected $fillable = array(
        'id',
        'after_hours_number',
        'compensated_number',
        'final_compensable_number',
        'employee_id',
        'time_sheet_id',
        'surname',
        'post_id',
        'rank_id'
    );

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function post()
    {
        return $this->hasOne(DictPost::class, 'id', 'post_id');
    }

    public function rank()
    {
        return $this->hasOne(DictRank::class, 'id', 'rank_id');
    }

    public function employeesUnit()
    {
        return $this->hasOne(EmployeesUnit::class, 'id', 'employees_unit_id');
    }

    public function timeSheetEmployeeDays()
    {
        return $this->hasMany(TimeSheetEmployeeDay::class);
    }

    public function timeSheetEmployeeCompensableDays()
    {
        return $this->hasMany(TshEmployeeCompensableDay::class);
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['employee_id'])) {
            $query->where('employee_id', $params['employee_id']['o'], $params['employee_id']['v']);
        }
        if (isset($params['day'])) {
            $query->where('day', '>', $params['day']['v']);
        }
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
