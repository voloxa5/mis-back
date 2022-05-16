<?php

namespace App\Http\Controllers;

use App\DocumentLock;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DocumentLockController extends Controller
{
    public function store(Request $request)
    {
        $items = new DocumentLock();

        $items->document_id = $request->get('document_id');
        $items->session_id = $request->get('session_id');
        $items->lock_time = new DateTime();
        $items->user_id = auth()->guard('api')->user()['id'];

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        try {
            DB::table('document_locks')->where('document_id', '=', $id)->delete();
        } catch (Exception $e) {
        }
    }

}
