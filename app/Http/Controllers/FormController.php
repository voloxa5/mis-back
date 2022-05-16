<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    public function index(Request $request)
    {
        return response(Form::filter($request)->with('domain')->
        get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Form();

        $items->name = $request->get('name');
        $items->description = $request->get('description');
        $items->content = $request->get('content');
        $items->domain_id = $request->get('domain_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return Form::with('domain')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = Form::findOrFail($id);
        $item->update($request->all());

        return response($item, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Form::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
