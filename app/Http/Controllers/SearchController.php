<?php


namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function find(Request $request): Response
    {
//        $params = $request['params'];//Условия для отбора
//        $name = $request['name'];//Название таблицы
//        //Подчиненные объекты, либо перечисление - ограниченный набор,
//        // либо null - все, либо пустой массив - ничего
//        $subs = $request['subs'];
//
//        $result = DB::table($name);
//
//        foreach ($params as $param) {
//            $result = $result->where($name . '.' . $param['name'], $param['operation'], $param['value']);
//        }
//
//        $result = $result->select($name . '.*');
//
//        foreach ($subs as $sub) {
//            $result = $result->join(
//                $sub['table'],
//                $sub['table'] . '.id',
//                '=',
//                $name . '.' . Str::singular($sub['name']) . '_id'
//            );
//            array_unshift($sub['fields'], 'id');
//            foreach ($sub['fields'] as $field) {
//                $result = $result->addSelect(
//                    $sub['table'] . '.' . $field . ' as ' . $sub['name'] . '.' . $field);
//            }
//        }
//
//        return response($result->get()->jsonSerialize(), Response::HTTP_OK);
        return response(0, Response::HTTP_OK);
    }
}
