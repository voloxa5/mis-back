<?php

namespace App\Http\Controllers;

use App\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TimeSheetEmployeeDayController extends Controller
{
    public function index(Request $request)
    {
        $request = json_decode($request->q, true);

        return response(TimeSheet::filter($request)
            ->with('employee')
            ->get(),
            Response::HTTP_OK);
    }

    public function show($id)
    {
        return TimeSheet::findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = new TimeSheet();

        $item->employee_id = $request->get('employee_id');
        $item->from_time = $request->get('from_time');
        $item->to_time = $request->get('to_time');
        $item->day = $request->get('day');
        $item->month = $request->get('month');
        $item->year = $request->get('year');
        $item->explanatory_date = $request->get('explanatory_date');
        $item->code = $request->get('code');
        $item->exposition_text = $request->get('exposition_text');
        $item->employees_unit_id = $request->get('employees_unit_id');

        $item->save();

        return response($item->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = TimeSheet::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = TimeSheet::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
