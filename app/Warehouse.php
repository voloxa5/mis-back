<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Warehouse
 *
 * @mixin \Eloquent
 * @property mixed title
 * @property mixed name
 */
class Warehouse extends Model
{
    protected $fillable = array(
        'title',
        'name',
    );
}
