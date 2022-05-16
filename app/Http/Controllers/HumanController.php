<?php

namespace App\Http\Controllers;

use App\Human;
use App\TaskHuman;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class HumanController extends Controller
{
    public function index()
    {
        return response(Human::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $item = new Human();

        $item->name = $request->get('name');
        $item->surname = $request->get('surname');
        $item->patronymic = $request->get('patronymic');
        $item->sex_id = $request->get('sex_id');
        $item->dob = $request->get('dob');
        $item->info = $request->get('info');

        try {
            $item->save();
        } catch (Exception $e) {
            DB::rollBack();
        }

        if (isset($request['parent_task_id'])) {
            $link = new TaskHuman();
            $link->task_id = $request->get('parent_task_id');
            $link->human_id = $item->id;
            $link->task_human_role_id = $request->get('taskHumanRoleId');
            try {
                $link->save();
            } catch (Exception $e) {
                DB::rollBack();
            }
        }
        DB::commit();
        return response($item->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return Human::with('domain')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = Human::findOrFail($id);
        $item->update($request->all());

        return response($item, Response::HTTP_OK);
    }

    public function destroy($id, Request $request)
    {
        DB::beginTransaction();
        if (isset($request['parent_task_id'])) {
            //todo пока сделаю получение ид связи через новый запрос, возможно стоит хранить его и пересылать с фронта?
            $link = TaskHuman
                ::where('task_id', $request['parent_task_id'])
                ->where('human_id', $id)
                ->first();
            try {
                $link->delete();
            } catch (Exception $e) {
                DB::rollBack();
                return response(null, Response::HTTP_PRECONDITION_FAILED);
            }
        }
        $item = Human::find($id);
        try {
            $item->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return response(null, Response::HTTP_PRECONDITION_FAILED);
        }
        DB::commit();
        return response(null, Response::HTTP_OK);
    }
}
