<?php

namespace App\Http\Controllers;

use App\DictResult;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictResultController extends Controller
{
    public function index()
    {
        return response(DictResult::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictResult();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictResult::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictResult::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictResult::findOrFail($id);
    }
}
