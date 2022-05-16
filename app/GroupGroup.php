<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupGroup extends Model
{
    protected $fillable = array('parent_id', 'child_id');
}
