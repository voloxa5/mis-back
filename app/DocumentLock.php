<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed document_id
 * @property mixed user_id
 * @property mixed lock_time
 * @property mixed session_id
 * @property mixed cancellation_time
 * @property mixed canceller_id
 */
class DocumentLock extends Model
{
    use HasFactory;

    protected $fillable = array(
        'document_id',
        'user_id',
        'lock_time',
        'session_id',
        'cancellation_time',
        'canceller_id',
    );
}
