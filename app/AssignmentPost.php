<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentPost extends Model
{
    protected $fillable = array(
        'appointment_date',
        'order_date',
        'order_number',
        'post_id'
    );

    public function post()
    {
        return $this->hasOne(DictPost::class, 'id');
    }
}
