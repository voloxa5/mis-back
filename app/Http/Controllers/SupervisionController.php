<?php

namespace App\Http\Controllers;

use App\Supervision;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupervisionController extends Controller
{
    public function index()
    {
        return response(Supervision::with('task')->with('shifts')->get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Supervision();

        $items->task_id = $request->get('task_id');
        $items->start_date = $request->get('start_date');
        $items->end_date = $request->get('end_date');
        $items->content = $request->get('content');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Supervision::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Supervision::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return Supervision::with('tasks')->findOrFail($id);
    }
}
