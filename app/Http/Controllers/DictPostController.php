<?php

namespace App\Http\Controllers;

use App\DictPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictPostController extends Controller
{
    public function index()
    {
        return response(DictPost::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictPost();
        $items->value = $request->get('value');
        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictPost::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictPost::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictPost::findOrFail($id);
    }
}
