<?php

namespace App\Http\Controllers;

use App\AssignmentRank;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssignmentRankController extends Controller
{
    public function index()
    {
        return response(AssignmentRank::with('rank')->get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new AssignmentRank();

        $items->assignment_date = $request->get('assignment_date');
        $items->order = $request->get('order_date');
        $items->order_number = $request->get('order_number');
        $items->rank_id = $request->get('rank_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = AssignmentRank::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = AssignmentRank::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return AssignmentRank::findOrFail($id);
    }
}
