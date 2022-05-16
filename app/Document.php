<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed type
 * @property mixed title
 * @property mixed content
 * @property mixed domain_type_id
 * @property mixed domain_id
 * @property mixed mn
 * @property mixed reg_number
 * @property mixed reg_date
 * @property mixed creator_id
 * @property mixed owner_id
 * @property mixed sender_id
 * @property mixed addressee_id
 * @property mixed form_id
 * @property mixed template_id
 * @property mixed secrecy_degree_id
 * @property mixed document_definition_id
 * @property mixed secrecy_clause
 * @property mixed general_domain_storage
 * @property mixed print_date
 * @property mixed who_printed_id
 * @property mixed form_name
 */
class Document extends Model
{
    protected $fillable = array(
        'type',
        'title',
        'content',
        'domain_type_id',
        'domain_id',
        'mn',
        'reg_number',
        'reg_date',
        'creator_id',
        'owner_id',
        'sender_id',
        'addressee_id',
        'form_id',
        'template_id',
        'secrecy_degree_id',
        'secrecy_clause',
        'document_definition_id',
        'general_domain_storage',
        'print_date',
        'who_printed_id',
        'form_name',
        'paper_case_id',
        'is_in_paper_case'
    );

    public function secrecyDegree()
    {
        return $this->hasOne(DictSecrecyDegree::class, 'id', 'secrecy_degree_id');
    }

    public function creator()
    {
        return $this->hasOne(Group::class, 'id', 'creator_id');
    }

    public function domain()
    {
        return $this->hasOne(Domain::class, 'id', 'domain_type_id');
    }

    public function whoPrinted()
    {
        return $this->hasOne(Employee::class, 'id', 'who_printed_id');
    }

    public function owner()
    {
        return $this->hasOne(Group::class, 'id', 'owner_id');
    }

    public function addressee()
    {
        return $this->hasOne(Group::class, 'id', 'addressee_id');
    }

    public function sender()
    {
        return $this->hasOne(Group::class, 'id', 'sender_id');
    }

    private function where($query, $params, $paramName, $isOr = false)
    {
        if (!$isOr) {
            if (!strpos($params[$paramName], ',')) {
                $query->where($paramName, '=', $params[$paramName]);
            } else {
                $array = explode(',', $params[$paramName]);
                $query->whereIn($paramName, $array);
            }
        } else {
            if (!strpos($params[$paramName], ',')) {
                $query->orWhere($paramName, '=', $params[$paramName]);
            } else {
                $array = explode(',', $params[$paramName]);
                $query->orWhereIn($paramName, $array);
            }

        }
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['owner_or_sender_or_addressee_id'])) {
            $this->where($query, $params, 'owner_id');
            $this->where($query, $params, 'sender_id', true);
            $this->where($query, $params, 'addressee_id', true);
            $this->where($query, $params, 'creator_id', true);
        } else if (isset($params['owner_id']) && $params['owner_id'] !== 'null') {
            $this->where($query, $params, 'owner_id');
        } else if (isset($params['owner_id']) && $params['owner_id'] === 'null') {
            $query->whereNull('owner_id');
        }
        if (isset($params['sender_id']) && $params['sender_id'] !== 'null') {
            $this->where($query, $params, 'sender_id');
        } else if (isset($params['sender_id']) && $params['sender_id'] === 'null') {
            $query->whereNull('sender_id');
        }
        if (isset($params['addressee_id']) && $params['addressee_id'] !== 'null') {
            $this->where($query, $params, 'addressee_id');
        } else if (isset($params['addressee_id']) && $params['addressee_id'] === 'null') {
            $query->whereNull('addressee_id');
        } else if (isset($params['document_definition_id'])) {
            if (str_contains($params['document_definition_id'], ','))
                $query->whereIn('document_definition_id', explode(',', $params['document_definition_id']));
            else
                $query->where('document_definition_id', '=', $params['document_definition_id']);
        }
        if (isset($params['paper_case_id'])) {
            $query = $query->where('paper_case_id', '=', $params['paper_case_id']);
        }
        if (isset($params['is_in_paper_case'])) {
            $query = $query->where('is_in_paper_case', '=', $params['is_in_paper_case']);
        }

        return $query;
    }
}
