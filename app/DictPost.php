<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static find($id)
 */
class DictPost extends Model
{
    protected $fillable = array(
        'value'
    );
}
