<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupGroup;
use App\Program;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ProgramController extends Controller
{
    public function index()
    {
        return response(Program::access()->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Program();

        if ($request->has('title'))
            $items->title = $request->get('title');
        if ($request->has('name'))
            $items->name = $request->get('name');
        $items->settings = $request->get('settings');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = Program::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = Program::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return Program::findOrFail($id);
    }
}
