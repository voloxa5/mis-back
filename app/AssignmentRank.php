<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentRank extends Model
{
    protected $fillable = array(
        'assignment_date',
        'order_date',
        'order_number',
        'rank_id'
    );

    public function rank()
    {
        return $this->hasOne(DictRank::class, 'id');
    }
}
