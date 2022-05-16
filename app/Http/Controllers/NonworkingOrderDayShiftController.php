<?php

namespace App\Http\Controllers;

use App\NonworkingOrderDayShift;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class NonworkingOrderDayShiftController extends Controller
{
    public function index(Request $request)
    {
        return response(NonworkingOrderDayShift::filter($request)->
//        with('nonworkingOrderDayShiftEmployee')->
        get()->all(),
            Response::HTTP_OK);
    }

    public function show($id)
    {
        return NonworkingOrderDayShift::
        with('nonworkingOrderDayShiftEmployee')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new NonworkingOrderDayShift();

        $items->time = $request->get('time');
        $items->nonworking_order_day_id = $request->get('nonworking_order_day_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = NonworkingOrderDayShift::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = NonworkingOrderDayShift::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
