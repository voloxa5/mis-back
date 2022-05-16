<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed sender_id
 * @property mixed owner_id
 * @property mixed addressee_id
 * @property mixed user_group_id
 * @property mixed document_id
 */
class MovingDocumentsLog extends Model
{
    protected $fillable = array(
        'sender_id',
        'owner_id',
        'addressee_id',
        'user_group_id',
        'document_id',
    );
}
