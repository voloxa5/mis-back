<?php


namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function arrayFirstValue($array, $default = null)
{
    foreach ($array as $item)
        return $item;
    return $default;
}

function treeTraversalByName(&$node, $fieldName, $callback, $parentNode = null, $prefix = ''): void
{
    static $uniqueIndexSubsNodeCounter = 1;
    $node['uniqueIndex'] = $uniqueIndexSubsNodeCounter++;
    //индексируем, что-бы затем различать однотипные таблицы от разных параметров введением псевдонимов
    $prefix = call_user_func($callback, $node, $parentNode, $prefix);

    if (isset($node[$fieldName]))
        foreach ($node[$fieldName] as $item) {
            treeTraversalByName($item, $fieldName, $callback, $node, $prefix);
        }
}

class AliasGenerator
{
    private int $index = 0;
    public array $items = array();

    public function get(string $name): string
    {
        $result = 'f' . ++$this->index;
        $this->items[$result] = $name;
        return $result;
    }

    public function getField(string $alias): string
    {
        return $this->items[$alias] ?? $alias;
    }
}

//если строка содержит дату, то преобразовываем в тип 'дата' или 'безвременная дата'
function ValueCast($value)
{
    if (((substr($value, -1)) === 'Z') && ((substr($value, 0, 1)) == 2) && (strlen($value) === 24)) {
        if (substr($value, 14, 9) === '00:00.000')
            return Carbon::parse(substr($value, 0, 10));
        else
            return Carbon::parse($value)->setTimezone('UTC');
    } else return $value;
}

class UniversalController extends Controller
{
    public function find(Request $request): Response
    {
        //    \Log::info($request);

        $params = $request['params'];//Условия для отбора
        $name = $request['name'];//Название таблицы
        //Подчиненные объекты, либо перечисление - ограниченный набор,
        // либо null - все, либо пустой массив - ничего
        $subs = $request['subs'];
        $table = DB::table($name);
        // формирование where
        $joiningType = null;
        foreach ($params as $param) {
            if ($joiningType === null)
                $joiningType = 'AND';
            else
                $joiningType = $param['joiningType'] ?? 'AND';

            if ($joiningType === 'AND') {
//                if (strpos($param['value'], ','))
                if ($param['operation'] === 'in')
                    $table = $table->whereIn($name . '.' . $param['name'], explode(',', $param['value']));
                else
                    $table = $table->where(
                        $name . '.' . $param['name'], $param['operation'],
                        $param['value'] === 'null' ? null : valueCast($param['value']));
            } else if ($joiningType === 'OR') {
                if ($param['operation'] === 'in')
                    $table = $table->orWhereIn($name . '.' . $param['name'], explode(',', valueCast($param['value'])));
                else
                    $table = $table->orWhere($name . '.' . $param['name'], $param['operation'], valueCast($param['value']));
            }
        }

        //добавим условие для реализации системы доступов к ресурсам
        if (in_array($name, ["document_definitions", ""])) {
            $user_id = auth()->guard('api')->user()->id;
            $is_admin = auth()->guard('api')->user()->is_admin;

            if (strval($is_admin) != 1) {
                $group_id = DB::table('groups')->where('user_id', $user_id)->first()->id;
                $parent_group_id_list = DB::table('group_groups')->where('child_id', $group_id)->pluck('parent_id')->toArray();
                $parent_group_id_list[] = $group_id;
                $parent_group_id_list = implode(',', $parent_group_id_list);
                $field = rtrim($name, 's');
                $table = $table->whereExists(function ($query) use ($parent_group_id_list, $name, $field) {
                    $query->select(DB::raw(1))
                        ->from("group_{$name}")
                        ->whereRaw("group_{$name}.{$field}_id = {$name}.id and group_{$name}.group_id in ($parent_group_id_list)");
                });
            }
        }

        // select по основной таблице
        $table = $table->select($name . '.*');

        // Подсоединение под.таблиц по данным subs

        //названия под.таблиц
        $subNames = [];

        $aliasGenerator = new AliasGenerator();

        treeTraversalByName($subs, 'subs', function ($node, $parentNode, $prefix)
        use ($aliasGenerator, &$subNames, $table) {
            if ($parentNode) {
                // Для объектных под/таблиц - название с большой буквы
                $prefix .= ($node['type'] === 'objects' ? ucfirst($node['name']) : $node['name']) . '.';

                array_push($subNames, $node['table']);

                //смотрим, если это талица связи, то заменим генерируемое поле на parent
                $isSiblingLink = in_array($node['table'], ['group_groups', '']);
                $tableAlias = $node['table'];

                $tableAlias = $node['table'] . ($node['uniqueIndex'] === 1 ? '' : $node['uniqueIndex']);
                $parentTableAlias = $parentNode['table'] . ($parentNode['uniqueIndex'] === 1 ? '' : $parentNode['uniqueIndex']);
                // что-бы различать однотипные таблицы от разных параметров вводим псевдонимы использую предварительное индексирование
                //        \Log::info($node);
                if ($node['type'] === 'containers') {
                    $table = $table->leftJoin(
                        $node['table'] . ' as ' . $tableAlias,
                        function ($join) use ($parentTableAlias, $tableAlias, $node, $isSiblingLink, $parentNode) {
                            $join->on($parentTableAlias . '.id',
                                '=',
                                $tableAlias . '.' .
                                //т.к. в документах все цепляется по domain_id
                                ($node['table'] === 'documents' ? 'domain' : ($isSiblingLink ? 'parent' : Str::singular($parentNode['table']))) . '_id'
                            );
                            if (isset($node['where'])) {
                                foreach ($node['where'] as $item) {
                                    $join = $join->where($tableAlias . '.' . $item['name'], $item['operation'], $item['value']);
                                }
                            }
                        });

//                    $table = $table->leftJoin(
//                        $node['table'] . ' as ' . $tableAlias,
//                        $parentTableAlias . '.id',
//                        '=',
//                        $tableAlias . '.' .
//                        //т.к. в документах все цепляется по domain_id
//                        ($node['table'] === 'documents' ? 'domain' : ($isSiblingLink ? 'parent' : Str::singular($parentNode['table'])))
//                        . '_id'
//                    );
                } else if ($node['type'] === 'objects')
                    $table = $table->leftJoin(
                        $node['table'] . ' as ' . $tableAlias,
                        $parentTableAlias . '.' . Str::singular($node['name']) . '_id',
                        '=',
                        $tableAlias . '.id'
                    );

                //Раздел select
                array_unshift($node['fields'], 'id');
                foreach ($node['fields'] as $field) {
                    //используем $aliasGenerator для временной замены названий полей, чтобы преодолеть ограничение размера в базе
                    $table = $table->addSelect(
                        $tableAlias . '.' . $field . ' as ' . $aliasGenerator->get($prefix . $field));
                }
            }

            return $prefix;
        });

        if ($request['sort_fields'])
            foreach ($request['sort_fields'] as $item)
                $table->orderBy($item, 'asc');


        // получаем коллекцию
        //   \Log::info($table->toSql());
        //   \Log::info($table->getBindings());

        $data = $table->get()->all();
        //вернем прежние названия полей
        $newData = [];
        foreach ($data as &$item) {
            $item = (array)$item;
            $newItem = [];
            foreach ($item as $key => &$val)
                $newItem[$aliasGenerator->getField($key)] = $val;
            $newData[] = $newItem;
        }
        $data = $newData;

        $subsArrayFull = [];

        // свертка объектов и массивов по типу eloquent
        foreach ($data as $item) {
            $subsArray = [];

            // Разнесем поля с разными префиксами по $subsArray
            foreach ($item as $key => $value) {
                $pos = strrpos($key, '.');
                if ($pos) {
                    $left = substr($key, 0, $pos);
                    $right = substr($key, $pos + 1);

                    $subsArray[$left][$right] = $value;
                } else {
                    $subsArray['root'][$key] = $value;
                }
            }

            // На основе $subsArray создадим дерево одной записи
            $subsArray = array_reverse($subsArray);
            foreach ($subsArray as $key => &$value) {

                $pos = strrpos($key, '.');
                if ($pos) {
                    $left = substr($key, 0, $pos);
                    $right = substr($key, $pos + 1);

                    // если первая буква прописная, то это объект
                    if (ctype_upper($right[0])) {
                        if ($value["id"])
                            $subsArray[$left][strtolower($right)] = &$value;
                        else
                            $subsArray[$left][strtolower($right)] = null;
                    } else {
                        if ($value["id"])
                            $subsArray[$left][$right][$value["id"]] = &$value;
                        else
                            $subsArray[$left][$right] = [];
                    }
                    unset($subsArray[$key]);
                } else if ($key !== 'root') {
                    if (ctype_upper($key[0])) {
                        if ($value["id"])
                            $subsArray['root'][strtolower($key)] = &$value;
                        else
                            $subsArray['root'][strtolower($key)] = null;
                    } else {
                        if ($value["id"])
                            $subsArray['root'][$key][$value["id"]] = &$value;
                        else
                            $subsArray['root'][$key] = [];
                    }
                    unset($subsArray[$key]);
                }
            }

            $val = $subsArray['root'];
            $subsArray = [];
            $subsArray[($val["id"])] = $val;

            // Объединим с ранее созданными
            $subsArrayFull = array_replace_recursive($subsArrayFull, $subsArray);
        }

        $subsArrayFull = array_values($subsArrayFull);

        function array_values_recursive(&$array)
        {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    if (is_int(array_key_first($value)))
                        $array[$key] = array_values($value);
                    array_values_recursive($array[$key]);
                }
            }
            return $array;
        }

        array_values_recursive($subsArrayFull);

        return response(json_encode($subsArrayFull), Response::HTTP_OK);
    }

    public function sql(Request $request): Response
    {
        if (!isset($request['sql']) && !isset($request['name']))
            return response('Нет данных для получения текста sql', Response::HTTP_INTERNAL_SERVER_ERROR);

        $sql = isset($request['sql'])
            ? $request['sql']
            : file_get_contents(base_path() . '/resources/sql/' . $request['name'] . '.sql');

        if (isset($request['vars']))
            foreach ($request['vars'] as $key => $value)
                $sql = str_replace('{$' . $key . '}', $value, $sql);

        if (strpos($sql, '{$'))
            return response('Присутствуют незаполненные подстановочные переменные', Response::HTTP_INTERNAL_SERVER_ERROR);

        $results = DB::select($sql);
        return response(json_encode($results), Response::HTTP_OK);
    }

    public function execSql(Request $request): Response
    {
        try {
            $sql = $request['sql'];
            $vars = $request['vars'];
            $results = DB::select($sql, $vars);
        } catch (Exception $e) {
            DB::rollBack();
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response(json_encode($results), Response::HTTP_OK);
    }

    public function saveLinkedObj(Request $request): Response
    {
        $childName = $request['name'];
        $parentName = $request['parent'];
        $data = $request['data'];
        $parentId = $request['id'];
        $linkingTableName = Str::singular($request['parent']) . '_' . $request['name'];
        $linkData = $request['link_data'];

        $parentFieldName = Str::singular($parentName) . '_id';
        $childFieldName = Str::singular($childName) . '_id';

        DB::beginTransaction();
        try {
            $childId = DB::table($childName)->insertGetId($data);

            $linkData[$parentFieldName] = $parentId;
            $linkData[$childFieldName] = $childId;

            $linkId = DB::table($linkingTableName)->insertGetId($linkData);
        } catch (Exception $e) {
            DB::rollBack();
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response($linkId, Response::HTTP_OK);
    }

    public function save(Request $request): Response
    {
        //\Log::info($request);
        function handler(&$value, $parentId = null, $parentType = null): int
        {
            $id = -1;
            $fields = $value['fields'];
            $type = $value['type'];

            switch ($value['state']) {
                case 'created':
                    if ($parentId && $parentType)
                        $fields[Str::singular($parentType) . '_id'] = $parentId;
                    $fields['created_at'] = new DateTime();//\Carbon\Carbon::now();

                    $dbConnection = Config::get('database.default');
                    if ($dbConnection === 'sqlite')
                        $value['id'] = DB::table($type)->insertGetId($fields);
                    else {
                        DB::table($type)->insert($fields);
                        $sequenceName = strtoupper(substr($type . '_ID_SEQ', 0, 30));
                        $value['id'] = DB::getSequence()->lastInsertId($sequenceName);
                    }
                    $id = $value['id'];
                    break;
                case 'changed':
                    $id = $value['id'];
                    $fields['updated_at'] = new DateTime();//\Carbon\Carbon::now();
                    DB::table($type)->where('id', $id)->update($fields);
                    break;
                case 'deleted':
                    $id = $value['id'];
                    DB::table($type)->delete($id);
                    break;
            }
            return $id;
        }

        function recursive($array)
        {
            //         $id=-1;
            foreach ($array as $key => $value) {
                if ($key === 'children') {
                    foreach ($value as $key2 => $value2) {
                        foreach ($value2['items'] as $key3 => $value3) {
                            if ($value3['state'] !== 'identity' && $value3['state'] !== 'null')
                                handler($value3, $array['id'], $array['type']);
                            if ($value3['state'] !== 'null')
                                recursive($value3);
                        }
                    }
                }
            }
            //        return $id;
        }

        DB::beginTransaction();
        try {
            $data = $request['data'];

            //     \Log::info($data);

            $id = handler($data);

            $result = ['id' => $id];
            if ($data['state'] === 'created')
                $result['createdAt'] = DB::table($data['type'])->select('created_at')->find($id)->created_at;
            if ($data['state'] === 'changed')
                $result['updatedAt'] = DB::table($data['type'])->select('updated_at')->find($id)->updated_at;

            recursive($data);

            DB::commit();
            return response($result, Response::HTTP_OK);
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            DB::rollBack();
            return response($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request): Response
    {
        $name = $request['name'];
        $data = $request['data'];
        $id = $request['id'];
        foreach ($data as &$field) //обнулим 'нулевую дату'
            if ($field === '1900-01-01 01:01:01')
                $field = null;

        try {
            $data['updated_at'] = \Carbon\Carbon::now();
            $result = DB::table($name)->where('id', $id)->update($data);
            return response('-1', Response::HTTP_OK);
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function insert(Request $request): Response
    {
        $name = $request['name'];
        $data = $request['data'];
        try {
            $data['created_at'] = \Carbon\Carbon::now();
            $id = DB::table($name)->insertGetId($data);
            return response($id, Response::HTTP_OK);
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            return response($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(Request $request): Response
    {
        $name = $request['name'];
        $id = $request['id'];

        try {
            DB::table($name)->delete($id);
            return response(null, Response::HTTP_OK);
        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cascadeDeletion(Request $request): Response
    {

        function getIds($tableName, $parentName, $ids): string
        {
            if (!$parentName) return $ids;

            $index = strrpos($parentName, '_');
            $val = substr($parentName, 0, $index + 1) . Str::singular(substr($parentName, $index + 1)) . '_id';
            $sql = "select {$tableName}.id from {$tableName} where {$val} in ({$ids})";
            $ids = '';
            foreach (db::select($sql) as $val) {
                $ids .= ($ids ? ',' : '') . $val->id;
            }
            return $ids;
        }

        function deleteTables($name, $ids)
        {
            $arrayId = explode(',', $ids);
            $tbl = DB::table($name);
            foreach ($arrayId as $key => $value) {
                if ($key === array_key_first($arrayId))
                    $tbl->where('id', $value);
                else
                    $tbl->orWhere('id', $value);
            }
            $tbl->delete();
        }

        function recursive($name, $array, $ids, $parent = null)
        {
            $ids = getIds($name, $parent, $ids);
            foreach ($array as $key => $value) {
                if ($ids)
                    recursive($key, $value, $ids, $name);
            }
            deleteTables($name, $ids);
        }

        $id = $request['id'];
        $data = $request['data'];
        DB::beginTransaction();
        try {
            recursive(array_key_first($data), arrayFirstValue($data), $id);
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            DB::rollBack();
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response(null, Response::HTTP_OK);
    }

    public function package(Request $request): Response
    {
        $name = $request['name'];
        $datasets = $request['datasets'];

        DB::beginTransaction();
        $result = array();
        try {
            foreach ($datasets as $value) {
                switch ($value['operation']) {
                    case  'delete':
                        foreach ($value['data'] as $record) {
                            if (count($record) > 0)
                                DB::table($name)->delete($record['id']);
                        }
                        break;
                    case  'update':
                        foreach ($value['data'] as $record) {
                            if (count($record) > 0) {
                                $record['updated_at'] = \Carbon\Carbon::now();
                                DB::table($name)->where('id', $record['id'])->update($record);
                            }
                        }
                        break;
                    case  'insert':
                        foreach ($value['data'] as $record) {
                            if (count($record) > 0) {
                                $record['created_at'] = \Carbon\Carbon::now();
                                $val = DB::table($name)->insertGetId($record);
                                array_push($result, $val);
                            }
                        }
                        break;
                }
            }
        } catch (Exception $e) {
            \Log::warning($e->getMessage());
            DB::rollBack();
            return response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();
        return response(json_encode($result), Response::HTTP_OK);
    }

    public function deleteLinkedObj(Request $request): Response
    {
        $linkId = $request['link_id'];
        $childId = $request['child_id'];
        $parentType = $request['parent_type'];
        $childType = $request['child_type'];

        $linkingTableName = Str::singular($parentType) . '_' . $childType;

        DB::beginTransaction();
        try {
            DB::table($linkingTableName)->delete($linkId);
            DB::table($childType)->delete($childId);
            DB::commit();
            return response($linkId, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function linkObj(Request $request): Response
    {
        $parentId = $request['parent_id'];
        $childId = $request['child_id'];
        $parentType = $request['parent_type'];
        $childType = $request['child_type'];
        $data = $request['data'];

        $parentFieldName = Str::singular($parentType) . '_id';
        $childFieldName = Str::singular($childType) . '_id';

        $linkingTableName = Str::singular($parentType) . '_' . $childType;

        $data[$parentFieldName] = $parentId;
        $data[$childFieldName] = $childId;

        DB::beginTransaction();
        try {
            $linkId = DB::table($linkingTableName)->insertGetId($data);
            DB::commit();
            return response($linkId, Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteLinkedObjWithoutLinkId(Request $request): Response
    {
        $parentId = $request['parent_id'];
        $childId = $request['child_id'];
        $parentType = $request['parent_type'];
        $childType = $request['child_type'];

        $parentFieldName = Str::singular($parentType) . '_id';
        $childFieldName = Str::singular($childType) . '_id';

        $linkingTableName = Str::singular($parentType) . '_' . $childType;

        $linkId = DB::table($linkingTableName)
            ->where($parentFieldName, '=', $parentId)
            ->where($childFieldName, '=', $childId)->first()->id;

        $request['link_id'] = $linkId;

        return $this->deleteLinkedObj($request);
    }

    public function getConstants(): Response
    {
        $guidTables = [
            'dict_int_reason_types',
            'dict_sexes',
            'document_definitions',
            'dict_task_human_roles',
            'dict_task_address_roles',
            'dict_task_vehicle_roles',
            'dict_task_legal_entity_roles',
            'dict_posts',
            'dict_term_reason_types',
            'paperwork_types',
            'dict_secrecy_degrees'
        ];

        $sql = '';
        foreach ($guidTables as $value) {
            if (!$sql) $sql .= ' union all ';
            $sql .= 'select id, guid from ' . $value . ' where guid is not null';
        }

//
//        $sql = "select id, guid
//from dict_int_reason_types
//where guid is not null
//union all
//select id, guid
//from dict_sexes
//where guid is not null
//union all
//select id, guid
//from document_definitions
//where guid is not null
//union all
//select id, guid
//from dict_task_human_roles
//where guid is not null
//union all
//select id, guid
//from dict_task_address_roles
//where guid is not null
//union all
//select id, guid
//from dict_task_vehicle_roles
//where guid is not null
//union all
//select id, guid
//from dict_task_legal_entity_roles
//where guid is not null
//union all
//select id, guid
//from dict_posts
//where guid is not null
//union all
//select id, guid
//from dict_term_reason_types
//where guid is not null";
        //todo сделать массив с генерацией sql

        $result = DB::select($sql);
        return response($result, Response::HTTP_OK);
    }

    public function exec(Request $request): Response
    {
        $funcName = $request['operation'];
        return $this->$funcName($request);
    }
}
