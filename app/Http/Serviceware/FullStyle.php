<?php

namespace App\Http\Serviceware;


class FullStyle
{
    private $name = '';
    private $firstLineIndent;
    private $leftIndent;
    private $fontSize;
    private $bold;
    private $fontName;
    private $fontColor;
    private $alignment;

    function __construct($style)
    {
        $this->firstLineIndent = $style['firstLineIndent'];
        $this->name = $style['name'];
        $this->alignment = $style['align'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFirstLineIndent(): int
    {
        return $this->firstLineIndent;
    }

    public function setFirstLineIndent(int $firstLineIndent): void
    {
        $this->firstLineIndent = $firstLineIndent;
    }

    public function getLeftIndent(): int
    {
        return $this->leftIndent;
    }

    public function setLeftIndent(int $leftIndent): void
    {
        $this->leftIndent = $leftIndent;
    }

    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    public function setFontSize(int $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    public function getBold(): bool
    {
        return $this->bold;
    }

    public function setBold(bool $bold): void
    {
        $this->bold = $bold;
    }

    public function getFontName(): string
    {
        return $this->fontName;
    }

    public function setFontName(string $fontName): void
    {
        $this->fontName = $fontName;
    }

    public function getFontColor(): string
    {
        return $this->fontColor;
    }

    public function setFonColor(string $fontColor): void
    {
        $this->fontColor = $fontColor;
    }

    public function getAlignment(): string
    {
        return $this->alignment;
    }

    public function setAlignment(string $alignment): void
    {
        $this->alignment = $alignment;
    }
}
