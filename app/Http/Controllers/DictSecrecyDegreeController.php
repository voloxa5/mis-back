<?php

namespace App\Http\Controllers;

use App\DictSecrecyDegree;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DictSecrecyDegreeController extends Controller
{
    public function index()
    {
        return response(DictSecrecyDegree::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictSecrecyDegree();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictSecrecyDegree::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictSecrecyDegree::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictSecrecyDegree::findOrFail($id);
    }
}
