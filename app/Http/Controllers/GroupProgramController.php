<?php

namespace App\Http\Controllers;

use App\GroupProgram;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupProgramController extends Controller
{
    public function index()
    {
        return response(GroupProgram::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new GroupProgram();
        $items->group_id = $request->get('group_id');
        $items->program_id = $request->get('program_id');
        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = GroupProgram::findOrFail($id);
        $item->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $item = GroupProgram::find($id);
        try {
            $item->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return GroupProgram::findOrFail($id);
    }
}
