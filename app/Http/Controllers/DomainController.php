<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $result = Domain::query();

        if (isset($request['subs'])) {
            $arr = explode(',', $request['subs']);
            foreach ($arr as $value) {
                $result->with('forms');
            }
        }

        return response($result->get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Domain();

        $items->name = $request->get('name');
        $items->title = $request->get('title');
        $items->general_domain_storage = $request->get('general_domain_storage');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return Domain::with('forms')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $items = Domain::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Domain::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
