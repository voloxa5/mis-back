<?php

namespace App\Http\Controllers;

use App\GroupDocumentDefinition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GroupDocumentDefinitionController extends Controller
{
    public function index()
    {
        return response(GroupDocumentDefinition::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new GroupDocumentDefinition();
        $items->group_id = $request->get('group_id');
        $items->document_definition_id = $request->get('document_definition_id');
        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = GroupDocumentDefinition::findOrFail($id);
        $item->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $item = GroupDocumentDefinition::find($id);
        try {
            $item->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return GroupDocumentDefinition::findOrFail($id);
    }

}
