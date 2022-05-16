<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed human_id
 * @property mixed photo_id
 * @property mixed is_basic
 * @property mixed id
 */
class HumanPhoto extends Model
{
    protected $fillable = array('human_id', 'photo_id', 'is_basic');
}
