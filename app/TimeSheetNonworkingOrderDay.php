<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeSheetNonworkingOrderDay extends Model
{
    protected $fillable = array(
        'nonworking_order_day',
        'time_sheet_nonworking_order_id',
    );
}
