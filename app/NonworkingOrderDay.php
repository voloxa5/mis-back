<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonworkingOrderDay extends Model
{
    protected $fillable = array(
        'day',
        'holiday_or_weekend',
        'nonworking_order_id',
    );
    /**
     * @var mixed
     */
    private $day;
    /**
     * @var mixed
     */
    private $holiday_or_weekend;
    /**
     * @var mixed
     */
    private $nonworking_order_id;

       public function nonworkingOrderDayShifts()
    {
        return $this->hasMany(NonworkingOrderDayShift::class, 'id');
    }
}
