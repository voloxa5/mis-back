<?php

namespace App\Http\Controllers;

use App\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        return response(Employee::filter($request)->
        with('post')->
        with('rank')->
        with('working')->
        with('sex')->
        with('employeesUnit')->
        get()->all(),
            Response::HTTP_OK);
    }

    public function show($id)
    {
        return Employee::
        with('post')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new Employee();

        $items->name = $request->get('name');
        $items->surname = $request->get('surname');
        $items->patronymic = $request->get('patronymic');
        $items->callsign = $request->get('callsign');
        $items->user_id = $request->get('user_id');
        $items->post_id = $request->get('post_id');
        $items->rank_id = $request->get('rank_id');
        $items->working_id = $request->get('working_id');
        $items->sex_id = $request->get('sex_id');
        $items->dob = $request->get('dob');
        $items->note = $request->get('note');
        $items->user_id = $request->get('user_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Employee::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Employee::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
