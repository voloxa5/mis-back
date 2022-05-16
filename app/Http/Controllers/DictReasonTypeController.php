<?php

namespace App\Http\Controllers;

use App\DictResult;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictReasonTypeController extends Controller
{
    public function index()
    {
        return response(DictReasonType::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictReasonType();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictReasonType::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictReasonType::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictReasonType::findOrFail($id);
    }
}
