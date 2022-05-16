<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupDocumentRole extends Model
{
    protected $fillable = array('id_dict_document_role', 'id_group_document');
}
