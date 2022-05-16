<?php

namespace App\Http\Serviceware;


interface iDocumentBuilder
{
    public function setHtml(string $value);

    public function getTitle(): string;

    public function setTitle(string $title): void;

    public function addParagraph(string $text = '', string $styleName = '');

    public function beginParagraph(string $styleName = '');

    public function endParagraph();

    public function addText($text);

    public function addParagraphs(int $count = 1);

    public function addStyle(FullStyle $style);

    public function addTable($content, $data);

    public function addList();

    public function output(): string;

}
