<?php

namespace App\Http\Controllers;

use App\ActualEmployee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActualEmployeeController extends Controller
{
    public function index()
    {
        return response(ActualEmployee::with('post')->with('rank')->with('working')->with('employee')->get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new ActualEmployee();

        $items->name = $request->get('name');
        $items->surname = $request->get('surname');
        $items->patronymic = $request->get('patronymic');
        $items->callsign = $request->get('callsign');
        $items->post_id = $request->get('post_id');
        $items->rank_id = $request->get('rank_id');


        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = ActualEmployee::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = ActualEmployee::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return ActualEmployee::findOrFail($id);
    }
}
