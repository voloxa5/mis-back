<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed title
 * @property mixed name
 * @property mixed description
 * @property mixed domain_id
 * @property mixed form_id
 * @property mixed template_id
 * @property mixed general_domain_storage
 */
class DocumentDefinition extends ProtectedModel
{
    protected $fillable = array(
        'name',
        'title',
        'description',
        'domain_id',
        'form_id',
        'template_id',
        'general_domain_storage'
    );

    public function domain()
    {
        return $this->hasOne(Domain::class, 'id', 'domain_id');
    }

    public function form()
    {
        return $this->hasOne(Form::class, 'id', 'form_id');
    }

    public function template()
    {
        return $this->hasOne(Template::class, 'id', 'template_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_document_definitions', 'document_definition_id', 'group_id')
            ->withPivot('id');
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['domain_id'])) {
            $query->where('domain_id', '=', $params['domain_id']);
        }
        return $query;
    }
}
