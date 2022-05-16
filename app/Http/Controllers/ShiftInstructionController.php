<?php

namespace App\Http\Controllers;

use App\ShiftInstruction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShiftInstructionController extends Controller
{

    public function index()
    {
        return response(ShiftInstruction::with('actualEmployee')->with('shift')->get()->all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new ShiftInstruction();

        $items->actual_employee_id = $request->get('actual_employee_id');
        $items->shift_id = $request->get('shift_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = ShiftInstruction::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = ShiftInstruction::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return ShiftInstruction::findOrFail($id);
    }
}


