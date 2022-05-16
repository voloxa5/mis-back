<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $filter = Document::with('domain')
            ->with('creator')
            ->with('whoPrinted')
            ->with('owner')
            ->with('addressee')
            ->with('sender')
            ->with('secrecyDegree');

        if ($request['order_by'])
            $filter->orderBy($request['order_by'], $request['direction']);

        $filter->filter($request);

    //  \Log::info( $filter->toSql());

        if (isset($request['per_page'])) {
            return response($filter->paginate($request['per_page'])->jsonSerialize(), Response::HTTP_OK);
        } else {
            return response($filter->get()->jsonSerialize(), Response::HTTP_OK);
        }
    }

    public function show($id)
    {
        return Document::with('creator')
            ->with('domain')
            ->with('whoPrinted')
            ->with('owner')
            ->with('addressee')
            ->with('sender')
            ->with('secrecyDegree')
            ->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $items = Document::findOrFail($id);
        $items->update($request->all());

        return response(null, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $items = new Document();

        $items->type = $request->get('type');
        $items->title = $request->get('title');
        $items->content = $request->get('content');
        $items->domain_type_id = $request->get('domain_type_id');
        $items->domain_id = $request->get('domain_id');
        $items->reg_number = $request->get('mn');
        $items->reg_number = $request->get('reg_number');
        $items->reg_date = $request->get('reg_date');
        $items->creator_id = $request->get('creator_id');
        $items->owner_id = $request->get('owner_id');
        //todo разобраться с преобразованием null в -1
        $items->sender_id = $request->get('sender_id') == -1 ? null : $request->get('sender_id');
        $items->addressee_id = $request->get('addressee_id') == -1 ? null : $request->get('addressee_id');
        $items->form_id = $request->get('form_id');
        $items->template_id = $request->get('template_id');
        $items->secrecy_degree_id = $request->get('secrecy_degree_id');
        $items->secrecy_clause = $request->get('secrecy_clause');
        $items->document_definition_id = $request->get('document_definition_id');
        $items->general_domain_storage = $request->get('general_domain_storage');
        $items->print_date = $request->get('print_date');
        $items->who_printed_id = $request->get('who_printed_id');
        $items->form_name = $request->get('form_name');

        $items->save();

        return response($items->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $items = Document::find($id);
        try {
            $items->delete();
        } catch (Exception $e) {
        }
    }
}
