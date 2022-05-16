<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed time_sheet_id
 * @property mixed document_id
 * @property mixed nonworking_order_day
 */
class TimeSheetNonworkingOrder extends Model
{
    protected $fillable = array(
        'time_sheet_id',
        'document_id',
        'nonworking_order_day'
    );

    public function document()
    {
        return $this->hasOne(Document::class, 'id', 'document_id');
    }

    public function timeSheet()
    {
        return $this->hasOne(TimeSheet::class, 'id', 'time_sheet_id');
    }
}
