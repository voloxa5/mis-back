<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonworkingOrderDayShiftEmployee extends Model
{
    protected $fillable = array(
        'employee_id',
        'nonworking_order_day_shift_id',
        'surname',
        'rank_id',
        'post_id'
    );
    /**
     * @var mixed
     */
    private $employee_id;
    /**
     * @var mixed
     */
    private $nonworking_order_day_shift_id;
    /**
     * @var mixed
     */
    private $surname;
    /**
     * @var mixed
     */
    private $rank_id;
    /**
     * @var mixed
     */
    private $post_id;

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id');
    }

    public function rank()
    {
        return $this->hasOne(DictRank::class, 'id');
    }

    public function post()
    {
        return $this->hasOne(DictPost::class, 'id' );
    }
}
