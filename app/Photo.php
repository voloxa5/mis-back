<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photo
 * @package App
 * @mixin Eloquent
 * @property mixed title
 * @property mixed description
 * @property mixed picture
 * @property mixed image_type
 * @property mixed owner_id
 * @property mixed linked
 */
class Photo extends Model
{
    protected $fillable = array(
        'title',
        'description',
        'picture',
        'image_type',
        'owner_id',
        'linked',
    );
}
