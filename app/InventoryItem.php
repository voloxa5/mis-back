<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\InventoryItem
 *
 * @mixin Eloquent
 * @property mixed title
 * @property mixed warehouse_id
 * @property mixed description
 * @property mixed category
 * @property mixed inventory_number
 */
class InventoryItem extends Model
{
    protected $fillable = array(
        'title',
        'warehouse_id',
        'description',
        'category',
        'inventory_number'
    );

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class);
    }
}
