<?php

namespace App\Http\Controllers;

use App\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index()
    {
        return response(Task::with('supervisions')->
        with('ratifyingPost')->
        with('object')->
        with('supervisions')->
        with('links')->
        with('performer')->
        with('performer.post')->
        with('performer.rank')->
        //    with('supervisions.shifts')->
        //    with('supervisions.shifts.instructions')->
        //    with('supervisions.shifts.instructions.actual_employee')->
        //    with('supervisions.shifts.instructions.actual_employee.post')->
        get()->all(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return Task::with('ratifyingPost')
            ->with('object')
            ->with('links.basicPhoto')
            ->with('object.basicPhoto')
            ->with('links')
            ->with('taskHumans_Humans')
            ->with('supervisions')
            ->with('performer')
            ->with('performer.post')
            ->with('performer.rank')
            ->findOrFail($id);
    }

    public function store(Request $request)
    {
        $items = new Task();

        $items->alias_name = $request->get('alias_name');
        $items->number = $request->get('number');
        $items->memorandum = $request->get('memorandum');
        $items->initiator_full_name = $request->get('initiator_full_name');
        $items->initiator_phone = $request->get('initiator_phone');
        $items->reg_date = $request->get('reg_date');
        $items->day_count = $request->get('day_count');
        $items->ratifying_name = $request->get('ratifying_name');
        $items->ratifying_dob = $request->get('ratifying_dob');
        $items->ratifying_post_id = $request->get('ratifying_post_id');
        $items->ratifying_rank_id = $request->get('ratifying_rank_id');
        $items->need_know_information = $request->get('need_know_information');
        $items->revocation_form_number = $request->get('revocation_form_number');
        $items->performer_id = $request->get('performer_id');
        $items->work_direction_id = $request->get('work_direction_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Task::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Task::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
