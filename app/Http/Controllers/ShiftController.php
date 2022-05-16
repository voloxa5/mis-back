<?php

namespace App\Http\Controllers;

use App\Shift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShiftController extends Controller
{
    public function index()
    {
//        with('supervision')->
        return response(Shift::
        with('instructions')->
        with('instructions.actual_employee')->
        with('instructions.actual_employee.post')->
        with('instructions.actual_employee.rank')->
        with('wasObserved')->
        get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Shift();

        $items->number = $request->get('number');
        $items->start_time = $request->get('start_time');
        $items->end_time = $request->get('end_time');
        $items->was_observed_id = $request->get('was_observed_id');
        $items->supervision_condition = $request->get('supervision_condition');
        $items->supervision_id = $request->get('supervision_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Shift::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Shift::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return Shift::findOrFail($id);
        // return Shift::with('supervisions')->findOrFail($id);
    }
}



