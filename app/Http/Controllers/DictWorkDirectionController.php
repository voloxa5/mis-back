<?php

namespace App\Http\Controllers;

use App\DictWorkDirection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictWorkDirectionController extends Controller
{
    public function index()
    {
        return response(DictWorkDirection::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictWorkDirection();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictWorkDirection::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictWorkDirection::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictWorkDirection::findOrFail($id);
    }
}
