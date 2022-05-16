<?php

namespace App\Http\Controllers;

use App\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TimeSheetController extends Controller
{
    public function index(Request $request)
    {
        $request = json_decode($request->q, true);

        return response(TimeSheet::filter($request)
            ->get(),
            Response::HTTP_OK);
    }

    public function show($id)
    {
        return TimeSheet::
        with('employeesUnit')->
        with('ratifying')->
        with('ratifyingPost')->
        with('ratifyingRank')->
        with('performer')->
        with('performerPost')->
        with('performerRank')->
        with('document')->
        with('timeSheetEmployees')->
        with('timeSheetEmployees.timeSheetEmployeeDays')->
        with('timeSheetEmployees.employee')->
        with('timeSheetEmployees.post')->
        with('timeSheetEmployees.rank')->
        with('timeSheetEmployees.employeesUnit')->
        with('timeSheetEmployees.timeSheetEmployeeCompensableDays')->
        with('timeSheetNonworkingOrders')->
        with('timeSheetNonworkingOrders.document')->
        with('timeSheetNonworkingOrders.timeSheet')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = new TimeSheet();

        $item->month = $request->get('month');
        $item->year = $request->get('year');
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
