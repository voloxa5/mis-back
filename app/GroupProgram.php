<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed group_id
 * @property mixed program_id
 */
class GroupProgram extends Model
{
    protected $fillable = array('group_id', 'program_id');
}
