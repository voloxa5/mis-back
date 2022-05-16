<?php

namespace App\Http\Controllers;

use App\DictYesNo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DictYesNoController extends Controller
{
    public function index()
    {
        return response(DictYesNo::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new DictYesNo();

        $items->value = $request->get('value');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = DictYesNo::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = DictYesNo::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return DictYesNo::findOrFail($id);
    }
}
