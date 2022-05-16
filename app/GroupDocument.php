<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed group_id
 * @property mixed document_id
 */
class GroupDocument extends Model
{
    protected $fillable = array('group_id', 'document_id');
}
