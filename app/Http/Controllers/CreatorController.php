<?php


namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreatorController extends Controller
{
    private function getWhereArray($fieldsArray)
    {
        $where = [];
        foreach ($fieldsArray as $item) {
            foreach ($item as $key => $value) {
                $arr = [$key, '=', $value];
                array_push($where, $arr);
            }
        }
        return $where;
    }

    private function handleSubDomain($domain, $parent_domain, $parent_id)
    {
        $where = $this->getWhereArray($domain['fields']);
        $table = DB::table($domain['name'])->where($where)->get();

        $id = 90;
        if (count($table) === 0) {
            $arr = $domain['fields'];
            $fieldName = Str::singular($parent_domain) . '_id';
            $arr[0][$fieldName] = $parent_id;
            $id = DB::table($domain['name'])->insertGetId($arr[0]);
        }
        if ($domain['subDomain'])
            $this->handleSubDomain($domain['subDomain'], $domain['name'], $id);
    }

    public function exec(Request $request)
    {
        $where = $this->getWhereArray($request['fields']);
        $mainTable = DB::table($request['name'])->where($where)->first();

        DB::beginTransaction();
        try {
            if ($request['subDomain'])
                $this->handleSubDomain($request['subDomain'], $request['name'], $mainTable->id);
        } catch (Exception $e) {
            \Log::warning('Error - handleSubDomain. ' . $e->getMessage());
            DB::rollBack();
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        DB::commit();

        return response(null, Response::HTTP_OK);
    }
}
