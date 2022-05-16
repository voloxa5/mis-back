<?php

namespace App\Http\Serviceware;

use DateTime;

class TextHandlers
{
    static public function firstLetter(string $value): string
    {
        return mb_substr($value, 0, 1);
    }

    static public function getMonth(string $value): string
    {
        return TextHandlers::parentFormatMonth(substr($value, 5, 2));
    }

    static public function upper(string $value): string
    {
        return mb_strtoupper($value);
    }

    static public function lower(string $value): string
    {
        return mb_strtolower($value);
    }

    static public function formatMonth(string $value): string
    {
        $monthsList = array("январь", "февраль", "март", "апрель", "май", "июнь",
            "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
        return $monthsList[$value - 1];
    }

    static public function parentFormatMonth(string $value): string
    {
        $monthsList = array("января", "февраля", "марта", "апреля", "мая", "июня",
            "июля", "августа", "сентября", "октября", "ноября", "декабря");
        return $monthsList[$value - 1];
    }

    static public function formatDate(string $value, string $format = 'd.m.Y'): string
    {
        $date = DateTime::createFromFormat('Y-m-d', substr($value, 0, 10));
        return $date->format($format);
    }

    static public function fullName($value): string
    {
        return !$value ? '' : mb_substr(mb_strtoupper($value['name']), 0, 1) . '.' .
            mb_substr(mb_strtoupper($value['patronymic']), 0, 1) . '. ' .
            mb_substr(mb_strtoupper($value['surname']), 0, 1) . mb_substr(mb_strtolower($value['surname']), 1);
    }

    static public function upperFirstLetter(string $value): string
    {
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    static public function properCase(string $value): string
    {
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_strtolower(mb_substr($value, 1));
    }
}
