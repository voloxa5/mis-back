<?php

namespace App\Http\Controllers;

use App\DictRank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictRankController extends Controller
{
    public function index()
    {
        return response(DictRank::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictRank();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictRank::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictRank::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictRank::findOrFail($id);
    }
}
