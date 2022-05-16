<?php

namespace App\Http\Controllers;

use App\Http\Serviceware\PdfBuilder2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function createReport(Request $request)
    {
        $document = DB::table('documents')
            ->where('documents.id', '=', $request['document_id'])
            ->join(
                'dict_secrecy_degrees',
                'dict_secrecy_degrees.id',
                '=',
                'documents.secrecy_degree_id')
            ->leftJoin(
                'employees as who_performer_employees',
                'employees.id',
                '=',
                'documents.who_performer_id')
            ->leftJoin(
                'employees as who_printed_employees',
                'employees.id',
                '=',
                'documents.who_printed_id')
            ->select(
                'documents.mn',
                'documents.formatting_info',
                'documents.secrecy_clause',
                'documents.who_performer_id',
                'documents.who_printed_id',
                'documents.print_date',
                'dict_secrecy_degrees.value',
                'who_performer_employees.name as who_performer_name',
                'who_performer_employees.surname as who_performer_surname',
                'who_performer_employees.patronymic as who_performer_patronymic',
                'who_printed_employees.name as who_printed_name',
                'who_printed_employees.surname as who_printed_surname',
                'who_printed_employees.patronymic as who_printed_patronymic'
            )
            ->get()[0];

        $formattingInfo = [];
        foreach (($document->formatting_info ? json_decode($document->formatting_info, true) : []) as $item)
            $formattingInfo[$item['name']] = $item['value'];

        $model = DB::table('domains')->find($request['domain_type_id']);

        $controller = $model->general_domain_storage == 0
            ? app("App\Http\Controllers\\" . $model->name . "Controller")
            : app("App\Http\Controllers\\GeneralDomainController");

        $data = $controller->show($request['domain_id']);
        if ($model->general_domain_storage == 1) {
            $data = (object)json_decode($data->content, true);
        }

        $template = DB::table('templates')->find($request['template_id']);

        $content = PdfBuilder::exec(json_decode($template->content, true), $data, $document, $formattingInfo);
        $encodeContent = base64_encode($content);
        return response($encodeContent, Response::HTTP_OK);
    }

    public function createHTMLReport(Request $request)
    {
        $document = DB::table('documents')
            ->where('documents.id', '=', $request['document_id'])
            ->join(
                'dict_secrecy_degrees',
                'dict_secrecy_degrees.id',
                '=',
                'documents.secrecy_degree_id')
            ->leftJoin(
                'employees as who_performer_employees',
                'who_performer_employees.id',
                '=',
                'documents.who_performer_id')
            ->leftJoin(
                'employees as who_printed_employees',
                'who_printed_employees.id',
                '=',
                'documents.who_printed_id')
            ->select(
                'documents.content',
                'documents.mn',
                'documents.formatting_info',
                'documents.secrecy_clause',
                'documents.who_performer_id',
                'documents.who_printed_id',
                'documents.print_date',
                'dict_secrecy_degrees.value',
                'who_performer_employees.name as who_performer_name',
                'who_performer_employees.surname as who_performer_surname',
                'who_performer_employees.patronymic as who_performer_patronymic',
                'who_printed_employees.name as who_printed_name',
                'who_printed_employees.surname as who_printed_surname',
                'who_printed_employees.patronymic as who_printed_patronymic'
            )
            ->get()[0];

        $content = PdfBuilder2::exec($document->content,  $document);
        $encodeContent = base64_encode($content);
        return response($encodeContent, Response::HTTP_OK);
    }

    public function createReportHTML(Request $request)
    {
        $data = DB::table($request['domain_name'])->find($request['domain_id']);
        $template = DB::table('templates')->find($request['template_id']);

        $content = PdfBuilder::execHTML(json_decode($template->content, true), $data);
        $encodeContent = ($content);
        return response($encodeContent, Response::HTTP_OK);
    }
}
