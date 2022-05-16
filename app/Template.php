<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @property mixed name
 * @property mixed description
 * @property mixed content
 * @property mixed domain_id
 * @method static filter(Request $request)
 * @method static findOrFail($id)
 * @method static find($id)
 */
class Template extends Model
{
    protected $fillable = array(
        'name',
        'description',
        'content',
        'domain_id');

    public function scopeFilter($query, $params)
    {
        if (isset($params['domain_id'])) {
            $query->where('domain_id', '=', $params['domain_id']);
        }
        return $query;
    }
}
