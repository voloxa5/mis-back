<?php

namespace App\Http\Controllers;

use App\Template;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        return response(Template::filter($request)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Template();
        $items->name = $request->get('name');
        $items->description = $request->get('description');
        $items->content = $request->get('content');
        $items->domain_id = $request->get('domain_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Template::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Template::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return Template::findOrFail($id);
    }
}
