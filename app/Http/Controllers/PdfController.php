<?php

namespace App\Http\Controllers;

use App\Http\Serviceware\ReportBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public $successStatus = 200;

    public function exportPdf(Request $request)
    {
        $reportBuilder = new  ReportBuilder($request->get('template'), $request->get('data'));
        $content = $reportBuilder->exec();
        return response(['pdf' => $content], Response::HTTP_OK);
    }

    public function exportPdf2(Request $request)
    {
        $html = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"></head><body><htmlpageheader name="firstpage" style="display:none">
    <div style="text-align:center"></div>
</htmlpageheader><htmlpageheader name="otherpages" style="display:none">
    <div style="text-align:center; font-size:8pt">{PAGENO}</div>
</htmlpageheader><sethtmlpageheader name="firstpage" value="on" show-this-page="1" /><sethtmlpageheader name="otherpages" value="on" />' . $request['body'] . '</body></html>';
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [297, 210],
            'margin_bottom' => 10,
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 30,
            'margin_header' => 15,
            'margin_footer' => 5,
            'orientation' => 'P'
        ]);
        $mn = $request['mn'];
        $mpdf->SetHTMLFooter('<table><tr><td style="font-size:8pt">мн' . $mn . '</td></tr></table>');

        $mpdf->WriteHTML($html, 2);
        $content = $mpdf->Output('', 'S');
        $encodeContent = base64_encode($content);
        return response(['pdf' => $encodeContent], Response::HTTP_OK);
    }
}
