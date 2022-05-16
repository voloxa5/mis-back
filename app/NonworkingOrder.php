<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed signatory_id
 */
class NonworkingOrder extends Model
{
    protected $fillable = array(
        'signatory_id',
    );

       public function nonworkingOrderDays()
    {
        return $this->hasMany(NonworkingOrderDay::class, 'id');
    }

    public function nonworkingOrderTasks()
    {
        return $this->hasMany(NonworkingOrderTask::class, 'id');
    }
}
