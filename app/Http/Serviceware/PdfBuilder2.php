<?php

namespace App\Http\Serviceware;


use DateTime;
use Mpdf\Mpdf;
use Mpdf\MpdfException;


class PdfBuilder2
{
    public static function exec($html, $document)
    {
        //$template
        $format = "A4";
        $orientation = "P";
        $title = "title";
        $mirror = "0";

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $format,
            'orientation' => $orientation,
            'margin_left' => 30,
            'margin_right' => 10,
            'margin_top' => 20,
            'margin_bottom' => 20,
        ]);
        $mpdf->shrink_tables_to_fit = 1; //предотвратить изменение размеров всех таблиц
        $mpdf->SetTitle($title);
        $mpdf->mirrorMargins = $mirror;
        $mpdf->mirrorNumbering = $mirror;

        $footerContent = $document->mn ? "мн {$document->mn}" : '';

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
            "mgt" => '55',
        ]);

        $print_date = '';
        if ($document->print_date) {
            $date = DateTime::createFromFormat('Y-m-d', substr($document->print_date, 0, 10));
            $print_date = $date->format('d.m.Y');
        }

        $mn = $document->secrecy_clause ? "мн {$document->mn}" : "";
        $performerPrinted = ($document->who_performer_id === $document->who_printed_id ||
            ($document->who_performer_id && !$document->who_printed_id))
            ? "исп. и печ."
            . mb_substr($document->who_performer_name, 0, 1)
            . "."
            . mb_substr($document->who_performer_patronymic, 0, 1)
            . ". "
            . mb_convert_case($document->who_performer_surname, MB_CASE_TITLE_SIMPLE)
            . "<br />"
            . $print_date
            . "<p/>"
            :
            ((!$document->who_performer_id && $document->who_printed_id)
                ? "исп. и печ. "
                . mb_substr($document->who_printed_name, 0, 1)
                . "."
                . mb_substr($document->who_printed_patronymic, 0, 1)
                . ". "
                . mb_convert_case($document->who_printed_surname, MB_CASE_TITLE_SIMPLE)
                . "<br />"
                . $print_date
                . "<p/>"
                : ("исп. "
                    . mb_substr($document->who_performer_name, 0, 1)
                    . "."
                    . mb_substr($document->who_performer_patronymic, 0, 1)
                    . ". "
                    . mb_convert_case($document->who_performer_surname, MB_CASE_TITLE_SIMPLE)
                    . "<br />"
                    . "печ. "
                    . mb_substr($document->who_printed_name, 0, 1)
                    . "."
                    . mb_substr($document->who_printed_patronymic, 0, 1)
                    . ". "
                    . mb_convert_case($document->who_printed_surname, MB_CASE_TITLE_SIMPLE)
                    . "<br />"
                    . $print_date
                    . "<p/>"?:' '));

        $flipSide = "<sethtmlpagefooter value=\"-1\" show-this-page=\"1\" />"
            . "<p style='font-size: 10pt'>" //размер шрифта оборотки
            . str_repeat("<br />", 44)
            . "{$mn}<br />
отп. в 1 экз.<br />
экз. в дело ОПБ МВД по Чувашской Республике<br/>
файл не создавался<br/>"
            . $performerPrinted;
        $mpdf->WriteHTML($flipSide);
        return $mpdf->Output('', 'S');
    }

}
