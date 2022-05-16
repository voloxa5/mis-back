<?php

namespace App\Http\Controllers;

use App\GeneralDomain;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeneralDomainController extends Controller
{
    public function index()
    {
        return response(GeneralDomain::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new GeneralDomain();

        $items->content = $request->get('content');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = GeneralDomain::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = GeneralDomain::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return GeneralDomain::findOrFail($id);
    }
}
