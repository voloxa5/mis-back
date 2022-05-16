<?php

namespace App\Http\Controllers;

use App\EmployeesUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeesUnitController extends Controller
{
    public function index(Request $request)
    {
        return response(EmployeesUnit::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return EmployeesUnit::findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new EmployeesUnit();

        $items->title = $request->get('title');
        $items->unit_level = $request->get('unit_level');
        $items->subunit_level = $request->get('subunit_level');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = EmployeesUnit::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = EmployeesUnit::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
