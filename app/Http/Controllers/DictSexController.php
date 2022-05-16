<?php

namespace App\Http\Controllers;

use App\DictSex;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictSexController extends Controller
{
    public function index()
    {
        return response(DictSex::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictSex();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictSex::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictSex::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictSex::findOrFail($id);
    }
}
