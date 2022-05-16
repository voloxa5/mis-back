<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonworkingOrderDayShift extends Model
{
    protected $fillable = array(
        'time',
        'nonworking_order_day_id',
    );
    /**
     * @var mixed
     */
    private $nonworking_order_day_id;
    /**
     * @var mixed
     */
    private $time;

    public function nonworkingOrderDayShiftEmployees()
    {
        return $this->hasMany(NonworkingOrderDayShiftEmployee::class, 'id');
    }
}
