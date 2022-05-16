<?php


namespace App\Http\Serviceware;


class ReportBuilder
{
    private $documentBuilder = null;
    private $paragraphs = null;
    private $styles = null;
    private $data = null;

    public function __construct($template, $data)
    {
        $orientation = $template['pageSetup']['orientation'];
        $format = $template['pageSetup']['format'];
        $title = $template['title'];
        $this->paragraphs = $template['body'];
        $this->styles = $template['styles'];
        $this->data = $data;

        $this->documentBuilder = new DocumentBuilder($format, $orientation, $data);
        $this->documentBuilder->setTitle($title);
    }

    private function getStyle($styles, string $styleName): FullStyle
    {
        $result = null;
        foreach ($styles as $s) {
            if ($s['name'] === $styleName) {
                $result = $s;
                break;
            }
        }
        return new FullStyle($result);
    }

    private function addParagraph($content, FullStyle $style)
    {
        $this->documentBuilder->addStyle($style);

        //Посмотрим, есть ли стили у фрагментов
        $isStyled = false;
        foreach ($content as $t) {
            if (isset($t['ts'])) {
                $isStyled = true;
                break;
            }
        }

        if ($isStyled) {
            $this->documentBuilder->beginParagraph();

            foreach ($content as $t) {
                $text = $t['t'];
                $this->documentBuilder->addText($text);
            }
            $this->documentBuilder->endParagraph();
        } else {
            $text = "";
            foreach ($content as $t) {
                $str = $t['t'];
                if (strpos($str, '$') === 0) {
                    $str = ltrim($str, '$');
                    $str = $this->data[$str];
                }
                $text .= $str;
            }

            $this->documentBuilder->addParagraph($text, $style->getName());
        }
    }

    private function addTable($content, FullStyle $style)
    {
        $this->documentBuilder->addTable($content, $this->data);
    }

    public function exec()
    {
        foreach ($this->paragraphs as $p) {
            $styleName = $p['style'];
            $style = $this->getStyle($this->styles, $styleName);
            switch ($p['type']) {
                case 'paragraph':
                    $this->addParagraph($p['content'], $style);
                    break;
                case 'table':
                    $this->addTable($p['content'], $style);
                    break;
            }
        }

        return $this->documentBuilder->output();
    }
}
