<?php

namespace App\Http\Controllers;

use App\AssignmentPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssignmentPostController extends Controller
{
    public function index()
    {
        return response(AssignmentPost::with('post')->get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new AssignmentPost();

        $items->appointment_date = $request->get('appointment_date');
        $items->order = $request->get('order_date');
        $items->order_number = $request->get('order_number');
        $items->post_id = $request->get('post_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = AssignmentPost::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = AssignmentPost::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return AssignmentPost::findOrFail($id);
    }
}

