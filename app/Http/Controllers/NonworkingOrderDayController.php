<?php

namespace App\Http\Controllers;

use App\NonworkingOrderDay;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NonworkingOrderDayController extends Controller
{
    public function index(Request $request)
    {
        return response(NonworkingOrderDay::filter($request)->
//        with('nonworkingOrderDayShifts')->
        get()->all(),
            Response::HTTP_OK);
    }

    public function show($id)
    {
        return NonworkingOrderDay::
        with('nonworkingOrderDayShifts')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new NonworkingOrderDay();

        $items->day = $request->get('day');
        $items->holiday_or_weekend = $request->get('holiday_or_weekend');
        $items->nonworking_order_id = $request->get('nonworking_order_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = NonworkingOrderDay::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = NonworkingOrderDay::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
