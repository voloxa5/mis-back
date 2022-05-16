<?php

namespace App\Http\Controllers;

use App\NonworkingOrderDayShiftEmployee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NonworkingOrderDayShiftEmployeeController extends Controller
{
    public function index(Request $request)
    {
        return response(NonworkingOrderDayShiftEmployee::get()->all(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return NonworkingOrderDayShiftEmployee::
        with('employee')->
        with('rank')->
        with('post')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new NonworkingOrderDayShiftEmployee();
        $items->employee_id = $request->get('employee_id');
        $items->nonworking_order_day_shift_id = $request->get('nonworking_order_day_shift_id');
        $items->surname = $request->get('surname');
        $items->rank_id = $request->get('rank_id');
        $items->post_id = $request->get('post_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = NonworkingOrderDayShiftEmployee::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = NonworkingOrderDayShiftEmployee::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
