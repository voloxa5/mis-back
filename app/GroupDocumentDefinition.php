<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed group_id
 * @property mixed document_definition_id
 */
class GroupDocumentDefinition extends Model
{
    protected $fillable = array('group_id', 'document_definition_id');
}
