<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed task_id
 * @property mixed human_id
 * @property mixed task_human_role_id
 */
class TaskHuman extends Model
{
    protected $fillable = array('task_id', 'human_id', 'task_human_role_id');
}
