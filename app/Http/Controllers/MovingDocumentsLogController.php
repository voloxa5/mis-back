<?php

namespace App\Http\Controllers;

use App\MovingDocumentsLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class MovingDocumentsLogController extends Controller
{
    public function index()
    {
        return response(MovingDocumentsLog::all()->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new MovingDocumentsLog();
        $items->sender_id = $request->get('sender_id');
        $items->owner_id = $request->get('owner_id');
        $items->addressee_id = $request->get('addressee_id');
        $items->user_group_id = $request->get('user_group_id');
        $items->user_group_id = $request->get('document_id');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return MovingDocumentsLog::findOrFail($id);
    }
}
