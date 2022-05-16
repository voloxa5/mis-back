<?php

namespace App\Http\Controllers;

use App\JsonDomain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JsonDomainController extends Controller
{
    public function index()
    {
        return response(JsonDomain::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new JsonDomain();

        $items->domain_id = $request->get('domain_id');
        $items->domain = $request->get('domain');
        $items->content = $request->get('content');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = JsonDomain::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = JsonDomain::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return JsonDomain::findOrFail($id);
    }
}
