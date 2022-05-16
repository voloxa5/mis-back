<?php

namespace App\Http\Controllers;

use App\DocumentDefinition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DocumentDefinitionController extends Controller
{
    public function index(Request $request)
    {
        $filter = DocumentDefinition::filter($request)
            ->access()
            ->with('domain')
            ->with('groups')
            ->with('form')
            ->with('template')
            ->get();
        return response($filter, Response::HTTP_OK);
    }

    public function show($id)
    {
        return DocumentDefinition::
        with('domain')->
        with('form')->
        with('template')->
        findOrFail($id);
    }

    public function store(Request $request)
    {
        $item = new DocumentDefinition();

        $item->name = $request->get('name');
        $item->title = $request->get('title');
        $item->description = $request->get('description');
        $item->domain_id = $request->get('domain_id');
        $item->form_id = $request->get('form_id');
        $item->template_id = $request->get('template_id');
        $item->general_domain_storage = $request->get('general_domain_storage');

        $item->save();

        return response($item->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $item = DocumentDefinition::findOrFail($id);
        $item->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $item = DocumentDefinition::find($id);
        try {
            $item->delete();
        } catch (Exception $e) {
        }
    }
}
