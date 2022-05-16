<?php

namespace App\Http\Serviceware;


use DateTime;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

function getContentFile($fileName, $data): string
{
    $str = file_get_contents($fileName);
    foreach ($data as $key => $value) {
        if (gettype($value) === 'string')
            $str = str_replace('$' . $key, $value, $str);
    }
    return $str;
}

class PdfBuilder
{
    public static function exec($template, $data, $document, $formattingInfo)
    {
        $data = json_decode(json_encode($data), true); //перевожу в массив, иначе идут к.т. глюки со объектным свойством
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $template['page']['format'],
            'orientation' => $template['page']['orientation'],
            'margin_left' => 30,
            'margin_right' => 10,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);
        $mpdf->shrink_tables_to_fit = 1; //предотвратить изменение размеров всех таблиц
        $mpdf->SetTitle($template['page']['title']);
        $mpdf->mirrorMargins = $template['page']['mirror'];
        $mpdf->mirrorNumbering = $template['page']['mirror'];

        $footerContent = $document->mn ? "мн {$document->mn}" : '';

        $secrecyDegree = $document->value;
        $secrecyClause = $document->secrecy_clause;

        if ($template['version'] === '2.0') {
            $html = getContentFile(__DIR__ . '/./TmpHtml.html', $data);
            if (str_contains($html, '$eagle')) {
                $html = str_replace(
                    '$eagle',
                    file_get_contents(
                        base_path() . '\resources\images\eagle.svg'),
                    $html);
            }
        } else {
            $html = (new HtmlBuilder($template, $data, $secrecyDegree, $secrecyClause, $formattingInfo))->getHTML();
        }

        $header1 = array(
            'C' => array(
                'content' => '<div style=\"text-align: center\">{PAGENO}</div>',
                'font-size' => 10, //размер номерации страниц
                'font-family' => 'times-new-roman',
            )
        );
        $header2 = array(
            'C' => array('content' => '')
        );
        $footer1 = array(
            'L' => array(
                'content' => "<div style=\"text-align: left\">{$footerContent}</div>",
                'font-size' => 10, //размер mn
                'font-family' => 'times-new-roman',
            )
        );
        $footer2 = array(
            'L' => array('content' => '',)
        );

        $mpdf->defFooterByName('footer1', $footer1);
        $mpdf->defFooterByName('footer2', $footer2);
        $mpdf->defHeaderByName('header1', $header1);
        $mpdf->defHeaderByName('header2', $header2);

        $mpdf->setFooterByName('footer1', 'O');
        $mpdf->setFooterByName('footer2', 'E');
        $mpdf->setHeaderByName('header1', 'O');
        $mpdf->setHeaderByName('header2', 'E');

        $mpdf->AddPage();

        try {
            $mpdf->WriteHTML($html);
        } catch (MpdfException $e) {
        }

        $mpdf->AddPageByArray([
            "even-footer-name" => "footer2",
            "odd-footer-name" => "footer2",
            "suppress" => "on", //скрывает номер страницы документа, начиная с новой страницы
            "mgl" => '10',
            "mgt" => '-50',
        ]);

        $print_date = '';
        if ($document->print_date) {
            $date = DateTime::createFromFormat('Y-m-d', substr($document->print_date, 0, 10));
            $print_date = $date->format('d.m.Y');
        }

        $mn = $document->secrecy_clause ? "мн {$document->mn}" : "";

        $flipSide = "<sethtmlpagefooter value=\"-1\" show-this-page=\"1\" />"
            . "<p style='font-size: 10pt'>" //размер шрифта оборотки
            . str_repeat("<br />", 44)
            . "{$mn}<br />
отп. в 1 экз.<br />
экз. в дело ОПБ МВД по Чувашской Республике<br/>
файл не создавался<br/>
исп. и печ. "
            . mb_substr($document->name, 0, 1)
            . "."
            . mb_substr($document->patronymic, 0, 1)
            . ". "
            . mb_convert_case($document->surname, MB_CASE_TITLE_SIMPLE)
            . "<br />"
            . $print_date
            . "<p/>";
        $mpdf->WriteHTML($flipSide);
        return $mpdf->Output('', 'S');
    }

    public static function execHTML($template, $data)
    {
        $htmlBuilder = new HtmlBuilder($template, $data);
        $body = $htmlBuilder->getBody();
        $stylesheet = $htmlBuilder->getStyles();
        return ['body' => $body, 'styles' => $stylesheet];
    }
}
