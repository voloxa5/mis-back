<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonworkingOrderTask extends Model
{
    protected $fillable = array(
        'task_id',
        'nonworking_order_id'
    );
    /**
     * @var mixed
     */
    private $task_id;
    /**
     * @var mixed
     */
    private $nonworking_order_id;

    public function task()
    {
        return $this->hasOne(Task::class, 'id', 'task_id');
    }
}
