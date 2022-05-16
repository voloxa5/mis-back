<?php

namespace App\Http\Controllers;

use App\Mission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MissionController extends Controller
{
    public function index()
    {
        return response(Mission::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Mission();

        // $items->content = $request->get('content');
        $items->deadline = $request->get('deadline');
        $items->perform_date = $request->get('perform_date');
        $items->performer_id = $request->get('performer_id');
        $items->answerable_id = $request->get('answerable_id');
        $items->setting_date = $request->get('setting_date');
        $items->reason = $request->get('reason');
        $items->content = $request->get('content');
        $items->result = $request->get('result');
        $items->confirmation_info = $request->get('confirmation_info');
        $items->confirmation_document_id = $request->get('confirmation_document_id');
        $items->controlled = $request->get('controlled');
        $items->priority = $request->get('priority');
        $items->viewed_date = $request->get('viewed_date');
        $items->reason_type_id = $request->get('reason_type_id');
        $items->postponed_mission_id = $request->get('postponed_mission_id');



        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Mission::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Mission::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return Mission::findOrFail($id);
    }
}
