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
 */
class TimeSheetEmployeeDay extends Model
{
    protected $fillable = array(
        'id',
        'employee_id',
        'day',
        'month',
        'year',
        'explanatory_date',
        'code',
        'exposition_text',
        'to_hours',
        'from_time',
        'to_time',
        'employees_unit_id',
    );

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
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
