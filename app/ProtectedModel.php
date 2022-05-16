<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProtectedModel extends Model
{
    private function camelToSnake($input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }

    function scopeAccess($query)
    {
        $name = $this->camelToSnake(substr(get_class($this), 4));
        $user_id = auth()->guard('api')->user()->id;
        $is_admin = auth()->guard('api')->user()->is_admin;
        if (strval($is_admin) == 1) {
            $query->get();
        } else {
            $group_id = Group::where('user_id', $user_id)->get()->first()->id;
            $parent_group_id_list = GroupGroup::where('child_id', $group_id)->pluck('parent_id')->toArray();
            $parent_group_id_list[] = $group_id;
            $parent_group_id_list = implode(',', $parent_group_id_list);
            $query->whereExists(function ($query) use ($parent_group_id_list, $name) {
                $query->select(DB::raw(1))
                    ->from("group_{$name}s")
                    ->whereRaw("group_{$name}s.{$name}_id = {$name}s.id and group_{$name}s.group_id in ($parent_group_id_list)");
            })->get();
        }
    }
}
