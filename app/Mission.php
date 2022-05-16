<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mission
 *
 * @mixin Eloquent
 * @property mixed deadline
 * @property mixed perform_date
 * @property mixed performer_id
 * @property mixed answerable_id
 * @property mixed setting_date
 * @property mixed reason
 * @property mixed content
 * @property mixed result
 * @property mixed confirmation_info
 * @property mixed confirmation_document_id
 * @property mixed controlled
 * @property mixed priority
 * @property mixed viewed_date
 * @property mixed reason_type_id
 * @property mixed postponed_mission_id
 */
class Mission extends Model
{
    protected $fillable = array(
        'id',
        'deadline',
        'perform_date',
        'performer_id',
        'answerable_id',
        'setting_date',
        'reason',
        'content',
        'result',
        'confirmation_info',
        'confirmation_document_id',
        'controlled',
        'priority',
        'viewed_date',
        'reason_type_id',
        'postponed_mission_id'
    );

}
