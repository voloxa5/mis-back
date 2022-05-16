<?php

namespace App\Http\Serviceware;


use Mpdf\Mpdf;

class DocumentBuilder implements iDocumentBuilder
{
    private $styles = [];
    private $currentStyle;
    private $mpdf;
    private $html;
    private $stylesheet = null;
    private $title;
    private $data = null;

    public function __construct(string $format = 'A4', string $orientation = 'P', $data = null)
    {
        $this->data = $data;
        $this->mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $format,
            'orientation' => $orientation
        ]);
        $this->mpdf->SetTitle('mPDF');
    }

    public function setHtml(string $value)
    {
        $this->html = $value;
    }

    public function addParagraph(string $text = '', string $styleName = '')
    {
        if ($styleName == '')
            $styleName = $this->currentStyle->getName();
        $this->html .= '<p class="' . $styleName . '">' . $text . '</p>';
    }

    public function beginParagraph(string $styleName = '')
    {
        if ($styleName == '')
            $styleName = $this->currentStyle->getName();
        $this->html .= '<p class="' . $styleName . '">';
    }

    public function endParagraph()
    {
        $this->html .= '</p>';
    }

    public function addText($text)
    {
        if (strpos($text, '$') === 0) {
            $text = ltrim($text, '$');
            $text = $this->data[$text];
        }
        $this->html .= '<span>' . ' ' . $text . '</span>';
    }

    public function addParagraphs(int $count = 1)
    {
        for ($i = 0; $i < $count; ++$i) {
            $this->html .= '<p/>';
        }
    }

    public function addStyle(FullStyle $style)
    {
        $this->currentStyle = $style;

        if (!array_key_exists($style->getName(), $this->styles)) {
            $this->styles[$style->getName()] = $style;

            $this->stylesheet .= '.' . $style->getName() . ' {'
                . 'text-indent: ' . $style->getFirstLineIndent() . 'px; '
                . 'text-align: ' . $style->getAlignment()
                . '}';
        }
    }

    public function addTable($content, $data)
    {
        $columns = $content['columns'];
        $data = $data[$content['data']];
        $style = $content['style'];

        $thead = '';
        foreach ($columns as $c) {
            $thead .= '<th style = "border: 1px solid black; border-collapse: collapse; width: ' . $c['width'] . '%">' . $c['title'] . '</th>';
        }
        $thead = '<thead><tr>' . $thead . '</tr></thead>';
        $tbody = '';
        $textAlign = $style['textAlign'];
        foreach ($data as $d) {
            $tr = '';
            foreach ($columns as $column) {
                $text = $d[$column['name']];
                $tr .= '<td style = "border: 1px solid black; border-collapse: collapse; text-align: ' . $textAlign . '">' . $text . '</td>';
            }
            $tbody .= '<tr>' . $tr . '</tr>';
        }
        $tbody = '<tbody>' . $tbody . '</tbody>';

        $width = $style['width'];
        $this->html .=
            '<table style = "border: 1px solid black; border-collapse: collapse; width: ' . $width . '%">' .
            $thead .
            $tbody .
            '</table>';
    }

    public function addList()
    {
        // TODO: Implement addList() method.
    }

    public function output(): string
    {
        $this->mpdf->SetTitle($this->title);
        if ($this->stylesheet != null)
            $this->mpdf->WriteHTML($this->stylesheet, 1);
        $this->mpdf->WriteHTML($this->html, 2);
        $content = $this->mpdf->Output('', 'S');
        return base64_encode($content);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
