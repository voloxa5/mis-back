<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed name
 * @property mixed title
 * @property mixed general_domain_storage
 */
class Domain extends Model
{
    protected $fillable = array(
        'name',
        'title',
        'general_domain_storage'
    );

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
