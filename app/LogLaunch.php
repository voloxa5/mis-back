<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 * @property mixed exit_time
 * @property mixed start_time
 * @property mixed is_checked
 * @property mixed last_activity
 */
class LogLaunch extends Model
{
    protected $fillable = array('user_id', 'exit_time', 'start_time', 'is_checked', 'last_activity');
}
