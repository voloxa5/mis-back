<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed alias_name
 * @property mixed number
 * @property mixed memorandum
 * @property mixed initiator_full_name
 * @property mixed initiator_phone
 * @property mixed reg_date
 * @property mixed day_count
 * @property mixed ratifying_dob
 * @property mixed ratifying_name
 * @property mixed ratifying_post_id
 * @property mixed ratifying_rank_id
 * @property mixed need_know_information
 * @property mixed revocation_form_number
 * @property mixed performer_id
 * @property mixed work_direction_id
 */
class Task extends Model
{
    protected $fillable = array(
        'alias_name',
        'number',
        'memorandum',
        'initiator_full_name',
        'initiator_phone',
        'reg_date',
        'day_count',
        'ratifying_dob',
        'ratifying_name',
        'ratifying_post_id',
        'ratifying_rank_id',
        'need_know_information',
        'revocation_form_number',
        'performer_id',
        'work_direction_id',
    );

    public function supervisions()
    {
        return $this->hasMany(Supervision::class);
    }

    public function ratifyingPost()
    {
        return $this->hasOne(DictPost::class, 'id', 'ratifying_post_id');
    }

    function objects()
    {
        return $this
            ->belongsToMany(Human::class, 'task_humans', 'task_id', 'human_id')
            ->wherePivot('task_human_role_id', '=', 1);
    }

    public function object()
    {
        $result = $this->HasOneThrough(
            Human::class,
            TaskHuman::class,
            'task_id',
            'id',
            'id',
            'human_id',
        )->where('task_human_role_id', '=', 1);

        return $result;
    }

    function links()
    {
        return $this
            ->belongsToMany(Human::class, 'task_humans', 'task_id', 'human_id')
            ->wherePivot('task_human_role_id', '=', 2)
            ->withPivot('id');
    }

    function taskHumans_Humans()
    {
        return $this->belongsToMany(
            Human::class, 'task_humans', 'task_id', 'human_id');
    }

    public function performer()
    {
        return $this->hasOne(Employee::class, 'id', 'performer_id');
    }
}
