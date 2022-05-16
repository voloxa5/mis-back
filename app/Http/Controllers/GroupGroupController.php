<?php

namespace App\Http\Controllers;

use App\GroupGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class GroupGroupController extends Controller
{
    public function index()
    {
        return response(GroupGroup::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new GroupGroup();
        $items->parent_id = $request->get('parent_id');
        $items->child_id = $request->get('child_id');
        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = GroupGroup::findOrFail($id);
        $item->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $item = GroupGroup::find($id);
        try {
            $item->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return GroupGroup::findOrFail($id);
    }
}
