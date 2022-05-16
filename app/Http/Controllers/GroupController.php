<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $result = Group::filter($request)->
        with('user')->
        with('user.employee')->
        with('parents')->
        with('children')->
        with('programs')->
        with('roles')->
        with('children.programs')->
        with('children.roles')->
        with('documentDefinitions')->
        with('children.documentDefinitions')->
        with('children.user')->
        get()->all();
        return response($result, Response::HTTP_OK);
    }

    public function show($id)
    {
        return Group::
        with('user')->
        with('user.employee')->
        with('user.group')->
        with('parents')->
        with('children')->
        with('programs')->
        with('roles')->
        with('children.programs')->
        with('children.roles')->
        with('documentDefinitions')->
        with('children.documentDefinitions')->
        with('children.user')->
        with('parents.documents')->
        with('parents.ownDocuments')->
        with('parents.programs')->
        with('parents.roles')->
        with('documents')->
        with('ownDocuments')->
        with('children.user')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = new Group();

        $item->title = $request->get('title');
        $item->name = $request->get('name');
        $item->user_id = $request->get('user_id');
        $item->group_size = $request->get('group_size');
        $item->save();
        return response($item->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = Group::findOrFail($id);
        $item->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Group::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
