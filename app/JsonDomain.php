<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $domain_id
 * @property mixed domain
 * @property mixed content
 */
class JsonDomain extends Model
{
    /**
     * @var mixed
     */
    protected $fillable = array(
        'domain_id', 'domain', 'content'
    );
}
