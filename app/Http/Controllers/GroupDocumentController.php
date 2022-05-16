<?php

namespace App\Http\Controllers;

use App\GroupDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class GroupDocumentController extends Controller
{
    public function index(Request $request)
    {
        return response(GroupDocument::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return GroupDocument::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $items = GroupDocument::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new GroupDocument();

        $items->group_id = $request->get('group_id');
        $items->document_id = $request->get('document_id');
        $items->save();
        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function destroy($id, Request $request)
    {
        if (count($request->toArray()) === 0) {
            $items = GroupDocument::find($id);
            try {
                $items->delete();
            } catch (Exception $e) {
            }
        } else {
            $items = GroupDocument::where($request->toArray());
            try {
                $items->delete();
            } catch (Exception $e) {
            }
        }
    }
}
