<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TshEmployeeCompensableDay extends Model
{
    protected $fillable = array(
        'id',
        'hours_number',
        'day',
        'time_sheet_employee_id',
    );
    public function timeSheetEmployee()
    {
        return $this->hasOne(TimeSheetEmployee::class, 'id', 'time_sheet_employee_id');
    }
}
