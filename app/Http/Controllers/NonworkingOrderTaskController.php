<?php

namespace App\Http\Controllers;

use App\NonworkingOrderTask;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NonworkingOrderTaskController extends Controller
{
    public function index(Request $request)
    {
        return response(NonworkingOrderTask::filter($request)->
        get()->all(),
            Response::HTTP_OK);
    }

    public function show($id)
    {
        return NonworkingOrderTask::findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new NonworkingOrderTask();

        $items->task_id = $request->get('task_id');
        $items->nonworking_order_id = $request->get('nonworking_order_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = NonworkingOrderTask::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = NonworkingOrderTask::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
