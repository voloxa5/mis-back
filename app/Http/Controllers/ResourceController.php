<?php


namespace App\Http\Controllers;


use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{
    public function del(Request $request)
    {
        try {
            $items = DB::table('group_' . $request->name . 's')->
            where('id', '=', $request->id)->delete();
            return response(null, Response::HTTP_OK);
        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function add(Request $request)
    {
        try {
            $id = DB::table('group_' . $request->name . 's')->
            insertGetId(
                [
                    'group_id' => $request->id_1,
                    $request->name . '_id' => $request->id_2
                ]);
            $result = DB::table($request->name . 's')->find($request->id_2);
            $result->pivot = (object)array('id' => $id);
            return response(json_encode($result), Response::HTTP_OK);
        } catch (Exception $e) {
            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
