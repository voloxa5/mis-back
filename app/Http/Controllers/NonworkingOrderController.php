<?php

namespace App\Http\Controllers;

use App\NonworkingOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NonworkingOrderController extends Controller
{
    public function index(Request $request)
    {
        return response(NonworkingOrder::
        with('nonworkingOrderTasks')->
        with('nonworkingOrderTasks.task')->
        with('nonworkingOrderDays')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees.employee')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees.rank')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees.post')->
        get()->all(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return NonworkingOrder::
        with('nonworkingOrderTasks')->
        with('nonworkingOrderTasks.task')->
        with('nonworkingOrderDays')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees.employee')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees.rank')->
        with('nonworkingOrderDays.nonworkingOrderDayShifts.nonworkingOrderDayShiftEmployees.post')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = new NonworkingOrder();
        $item->signatory_id = $request->get('signatory_id');
        $item->save();

        return response($item->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = NonworkingOrder::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = NonworkingOrder::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
