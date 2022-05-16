<?php

namespace App;

use Eloquent;


/**
 * App\Program
 *
 * @mixin Eloquent
 * @property mixed title
 * @property mixed name
 * @property mixed settings
 */
class Program extends ProtectedModel
{
    protected $fillable = array(
        'title',
        'name',
        'settings',
    );
}
