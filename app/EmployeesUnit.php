<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed title
 * @property mixed unit_level
 * @property mixed subunit_level
 */
class EmployeesUnit extends Model
{
    protected $fillable = array(
        'title', 'unit_level', 'subunit_level');
}
