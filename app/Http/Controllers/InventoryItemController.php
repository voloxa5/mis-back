<?php

namespace App\Http\Controllers;

use App\InventoryItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InventoryItemController extends Controller
{
    public function index(Request $request)
    {
        $per_page = empty(request('per_page')) ? -1 : (int)request('per_page');
        return
            $per_page === -1 ?
                response(InventoryItem::all()->jsonSerialize(), Response::HTTP_OK) :
                response(InventoryItem::paginate($per_page)->jsonSerialize(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new InventoryItem();

        $items->title = $request->get('title');
        $items->warehouse_id = $request->get('warehouse_id');
        $items->description = $request->get('description');
        $items->category = $request->get('category');
        $items->inventory_number = $request->get('inventory_number');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $items = InventoryItem::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $items = InventoryItem::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }

    public function show($id)
    {
        return InventoryItem::findOrFail($id);
    }
}
