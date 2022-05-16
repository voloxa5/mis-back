<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed title
 * @property mixed name
 * @property mixed user_id
 * @property mixed group_size
 */
class Group extends Model
{
    protected $fillable = array('title', 'name', 'user_id', 'group_size');

    public function parents()
    {
        return $this->belongsToMany(
            Group::class, 'group_groups', 'child_id', 'parent_id')
            ->withPivot('id');
    }

    public function children()
    {
        return $this->belongsToMany(
            Group::class, 'group_groups', 'parent_id', 'child_id')
            ->withPivot('id');
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'group_documents', 'group_id', 'document_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'group_programs', 'group_id', 'program_id')
            ->withPivot('id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'group_roles', 'group_id', 'role_id')
            ->withPivot('id');
    }

    public function documentDefinitions()
    {
        return $this->belongsToMany(DocumentDefinition::class, 'group_document_definitions', 'group_id', 'document_definition_id')
            ->withPivot('id');
    }

    public function ownDocuments()
    {
        return $this->HasMany(Document::class, 'owner_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

//    public function link()
//    {
//        return $this->belongsTo(GroupGroup::class, 'id', 'child_id');
//    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['nonGroupUsersWithId'])) {
            $query->whereNotNull('user_id')
                ->whereNotExists(function ($query2) use ($params) {
                    $query2->select(DB::raw(1))
                        ->from('group_groups')
                        ->whereRaw(
                            'group_groups.child_id = groups.id and group_groups.parent_id='
                            . $params['nonGroupUsersWithId']);
                });
        }
        if (isset($params['parents_without_id'])) {
            $query->whereNull('user_id')
                ->whereNotExists(function ($query2) use ($params) {
                    $query2->select(DB::raw(1))
                        ->from('group_groups')
                        ->whereRaw(
                            'group_groups.parent_id = groups.id and group_groups.child_id='
                            . $params['parents_without_id']);
                });
        }
        if (isset($params['has_parents']) && $params['has_parents'] === 'false') {
            $query->whereNotExists(function ($query2) {
                $query2->select(DB::raw(1))
                    ->from('group_groups')
                    ->whereRaw('group_groups.child_id = groups.id');
            });
        }
        if (isset($params['user_id']) && $params['user_id'] === 'null') {
            $query->whereNull('user_id');
        }
        if (isset($params['user_id']) && $params['user_id'] === 'notNull') {
            $query->whereNotNull('user_id');
        }
        if (isset($params['name'])) {
            $query->where('name', 'like', $params['name'] . '%');
        }
        return $query;
    }
}
