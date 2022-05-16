<?php


namespace App\Http\Serviceware;

use DateTime;

function arrayFirstValue($array, $default = null)
{
    foreach ($array as $item) {
        return $item;
    }
    return $default;
}

function explodeOnce(string $value, string $delimiter): array
{
    $result = [];
    $index = mb_strpos($value, $delimiter);
    if ($index === -1)
        $result[0] = $value;
    else {
        $result[0] = mb_substr($value, 0, $index);
        $result[1] = mb_substr($value, $index + 1);
    }
    return $result;
}

function ternaryHandler(string $value): array
{
    $result = [];
    $index = mb_strpos($value, '=');
    $result[0] = mb_substr($value, 0, $index);
    $value = mb_substr($value, $index + 1);
    $index = mb_strpos($value, '?');
    $result[1] = mb_substr($value, 0, $index);
    $value = mb_substr($value, $index + 1);
    $index = mb_strpos($value, ':');
    $result[2] = mb_substr($value, 0, $index);
    $result[3] = mb_substr($value, $index + 1);

    return $result;
}

function inParenthesis(string $val): string
{
    $index = mb_strpos($val, '(');
    $val = mb_substr($val, $index + 1);
    return mb_substr($val, 0, -1);
}

function getFirstTeg(string $value, string $tag): string
{
    $result = preg_match_all("#<$tag>(.+?)</$tag>#su", $value, $matches);
    return $result ? $matches[1][0] : '';
}

function processResizer(string &$value, $formattingInfo)
{
    $value = preg_replace_callback(
        "#<resizer>(.+?)</resizer>#su",
        function ($matches) use ($formattingInfo) {
            $name = getFirstTeg($matches[1], 'name');
            $value = getFirstTeg($matches[1], 'value');
            return $formattingInfo[$name] ?? $value;
        },
        $value);
}

//Раскрываем подстановочные функции
function dataOperationHandler($val, $data, $functionArray = null): string
{
    $isFunc = false;
    if ($functionArray) {
        $indexBracket = mb_strpos($val, '(');
        $indexDot = mb_strpos($val, '.');
        $isFunc = $indexBracket;
        if ($indexDot)
            $isFunc = $indexBracket < $indexDot;
        $funcName = mb_substr($val, 0, $indexBracket);
        if ($isFunc) {
            $isFunc = array_key_exists($funcName, $functionArray);
        }
    }

    if ($isFunc) {
        $indexClosingBracket = mb_strpos($val, ')');
        $arg = mb_substr($val, $indexBracket + 1, $indexClosingBracket - $indexBracket - 1);
        $val = str_replace('$' . $functionArray[$funcName]['arg'], $arg, $functionArray[$funcName]['val']);
    }

    $val = str_replace("\n", '', $val);
    return recursiveDataHandler($val, $data);
}

function recursiveDataHandler($val, $data): string
{
    // реализовано тернар, разница дат, сумма строк
    if (mb_strpos($val, '?')) {
        $operationArr = ternaryHandler($val);

        $val1 = dataHandler($operationArr[0], $data);
        $val2 = $operationArr[1];
        if (mb_strtolower($val1) === mb_strtolower($val2)) {
            $result = recursiveDataHandler($operationArr[2], $data);
        } else {
            $result = recursiveDataHandler($operationArr[3], $data);
        }
    } else if (str_starts_with($val, '[')) { //сделано пока только для одной скобки
        $index = mb_strpos($val, ']');
        $a = substr($val, 1, $index - 1);
        $b = substr($val, $index + 1);
        $v = recursiveDataHandler($a, $data);
        $result = recursiveDataHandler($v . $b, $data);
    } else if (mb_strpos($val, '-')) {
        $operationArr = explode('-', $val);
        if (count($operationArr) === 1)
            $result = dataHandler($val, $data);
        else {
            $result = trim(recursiveDataHandler($operationArr[0], $data));
            if (strpos($result, '-'))
                $result = substr($result, 11, 2) * 60 + substr($result, 14, 2);

            for ($i = 1; $i < count($operationArr); ++$i) {
                $a = trim(recursiveDataHandler($operationArr[$i], $data));
                if (strpos($a, '-'))
                    $a = substr($a, 11, 2) * 60 + substr($a, 14, 2);
                if ($i === 1 && $result < $a) $result += 24 * 60; //фиксим, когда завершиться после 12-ти
                $result -= $a;
            }
            $result = $result / 60;
            $result = number_format($result, 2, ',', '.');
            $result = rtrim(rtrim($result, '0'), ',');
        }
    } else if (mb_strpos($val, '+')) {
        $operationArr = explodeOnce($val, '+');
        if (count($operationArr) === 1)
            $result = dataHandler($val, $data);
        else {
            $result =
                recursiveDataHandler($operationArr[0], $data) .
                recursiveDataHandler($operationArr[1], $data);
        }
    } else
        $result = dataHandler($val, $data);
    return $result;
}

function dataHandler($val, $data): string
{
    $arr = explode('.', $val);
    $result = $data;
    foreach ($arr as $item) {
        if (str_starts_with($item, 'firstLetter('))
            $result = mb_substr($result, 0, 1);
        else if (str_starts_with($item, 'counter(')) {
            static $counter = 1;
            $result = $counter++;
        } else if (str_starts_with($item, 'afterExisting(')) {
            $arg = rtrim(substr($item, 14), ')');
            $result = trim($result) === '' ? '' : $result . $arg;
        } else if (str_starts_with($item, 'beforeExisting(')) {
            $arg = rtrim(substr($item, 15), ')');
            $result = trim($result) === '' ? '' : $arg . $result;
        } else if (str_starts_with($item, 'handleRVK(')) {
            $result = str_replace(',', '.', $result);
            $result = $result > 2 ? ($result - 1) : $result;
        } else if (str_starts_with($item, 'handleYAS(')) {
            $result = str_replace(',', '.', $result);
            $result = (($result - 1) <= 8 ? 8 : $result - 1);
        } else if (str_starts_with($item, 'handleYAK(')) {
            $result = str_replace(',', '.', $result);
            $result = ($result - 1) <= 8 ? 8 : $result - 1;
        } else if (str_starts_with($item, 'getTime(')) {
            $result = date('H:i', strtotime($result));
        } else if (str_starts_with($item, 'getDate(')) {
            $result = date('d.m.y', strtotime($result));
        } else if (str_starts_with($item, 'getDateFullYear(')) {
            $result = date('d.m.Y', strtotime($result));
        } else if ((str_starts_with($item, 'round('))) {
            $result = round($result, 1);
        } else if ((str_starts_with($item, 'replace('))) {
            $argsString = rtrim(substr($item, 8), ')');
            $arr = explode(',', $argsString);
            foreach ($arr as &$value)
                $value = trim($value);
            for ($i = 0; $i < count($arr); $i += 2) {
                if ($result === $arr[$i]) {
                    $result = $arr[$i + 1];
                    break;
                }
            }
        } else if ((str_starts_with($item, 'columnSum('))) {
            if (count($result) === 0)
                $result = '0';
            else {
                $fieldName = substr($item, 10, mb_strlen($item) - 9 - 2);
                $sum = 0;
                foreach ($result as $value) {
                    $sum += $value[$fieldName];
                }
                $result = $sum;
            }
        } else
            if (str_starts_with($item, 'strPad(')) {
                $commaIndex = strpos($item, ',');
                $length = substr($item, 7, $commaIndex - 7);
                $padString = substr($item, $commaIndex + 1, mb_strlen($item) - $commaIndex - 2);
                $result = str_pad($result, $length, $padString, STR_PAD_LEFT);
            } else if (str_starts_with($item, 'upper('))
                $result = mb_strtoupper($result);
            else if (str_starts_with($item, 'lower('))
                $result = mb_strtolower($result);
            else if (str_starts_with($item, 'upperFirstLetter('))
                $result = mb_convert_case($result, MB_CASE_TITLE);
            else if (str_starts_with($item, 'find(')) {
                $args = explode(',', inParenthesis($item));
                $result = array_filter($result, function ($v) use ($args) {
                    return $v[$args[0]] == $args[1];
                });
                $result = count($result) === 0 ? '' : arrayFirstValue($result);
            } else {
                if ($result) {
                    $item = trim($item);
                    if (isset($result[$item])) {
                        $result = $result[$item];
                        if (is_null($result))
                            $result = '';
                    } else {
                        //todo вопиюще коряво, временная заглушка,
                        // иногда нужно $result = $item, а иногда $result = '', переделать
                        if ($result === 'rank' && $item === 'value')
                            $result = '';
                        else
                            $result = $item;
                    }
                }
            }
    }
    return $result;
}

//На скорую руку пока реализовано только вложенные данные первого уровня
function getNestedCycleData($data, $compositeKey): array
{
    $result = [];
    $arr = explode('.', $compositeKey);
    foreach ($data[$arr[0]] as $item) {
        $parent = [];
        $item['parent'] = $data;
        foreach ($item as $key => $value) {
            if ($key !== $arr[1])
                $parent[$key] = $value;
        }
        foreach ($item[$arr[1]] as $subItem) {
            $subItem['parent'] = $parent;
            $result[] = $subItem;
        }
    }
    return $result;
}

class HtmlBuilder
{
    private $template;
    private $data;
    private $formattingInfo;
    private string $content;
    private $secrecyDegree;
    private $secrecyClause;
    private string $htmlStyles = '';

    public function __construct($template, $data, $secrecyDegree, $secrecyClause, $formattingInfo)
    {
        $this->secrecyDegree = $secrecyDegree;
        $this->secrecyClause = $secrecyClause;
        $this->template = $template;
        $this->data = $data;
        $this->formattingInfo = $formattingInfo;
        $this->content = "";
    }

    public function getStyles(): string
    {
        $stylesheet = ".float-photo{
    float: right;
    width: 150px;
    margin: 5px;
}";
        foreach ($this->template["generalStyles"] as $style) {
            $stylesheet .= "." . $style['name'] .
                " {margin-top: 0cm; margin-right: 0cm; margin-bottom: 0cm; font-family: times-new-roman; ";
            if (isset($style['firstLineIndent'])) {
                $stylesheet .= "text-indent: " . $style['firstLineIndent'] . "cm; ";
            }
            if (isset($style['leftIndent'])) {
                $stylesheet .= "margin-left: " . $style['leftIndent'] . "cm; ";
            }
            if (isset($style['alignment']) && $style['alignment'] !== 'float') {
                $stylesheet .= "text-align: " . $style['alignment'] . "; ";
            }
            if (isset($style['fontSize'])) {
                $stylesheet .= "font-size: " . $style['fontSize'] . "pt; ";
            }
            if (isset($style['bold']) && $style['bold']) {
                $stylesheet .= "font-weight: bold";
            }
            $stylesheet .= "}";
        }
        foreach ($this->template["textStyles"] as $style) {
            $stylesheet .= "." . $style['name'] .
                " {margin-top: 0cm; margin-right: 0cm; margin-bottom: 0cm; font-family: times-new-roman; ";
            if (isset($style['firstLineIndent'])) {
                $stylesheet .= "text-indent: " . $style['firstLineIndent'] . "cm; ";
            }
            if (isset($style['leftIndent'])) {
                $stylesheet .= "margin-left: " . $style['leftIndent'] . "cm; ";
            }
            if (isset($style['alignment'])) {
                $stylesheet .= "text-align: " . $style['alignment'] . "; ";
            }
            if (isset($style['fontSize'])) {
                $stylesheet .= "font-size: " . $style['fontSize'] . "pt; ";
            }
            if (isset($style['bold']) && $style['bold']) {
                $stylesheet .= "font-weight: bold";
            }
            $stylesheet .= "}";
        }
        return $stylesheet;
    }

    public function getBody()
    {
        foreach ($this->template["body"] as $item) {
            if ($item["type"] === "paragraph") {
                $this->paragraph($item);
            } else if ($item["type"] === "table") {
                $this->table($item);
            }
        }
        return $this->content;
    }

    private function getValue($name)
    {
        if ($name === 'secrecy_degree') {
            return $this->secrecyDegree;
        } else if ($name === 'secrecy_сlause') {
            return $this->secrecyClause;
        } else {

            $value = $this->data;

            $indexDot = strpos($name, '.');
            if ($indexDot) {
                $name1 = substr($name, 0, $indexDot);
                $name2 = substr($name, $indexDot + 1);
                $value = $value[$name1];
                $name = $name2;
            }

            if (strpos($name, '_id')) {
                $value = $value[substr($name, 0, -3)];
                $name = 'value';
            }
            return $value ? $value[$name] : '';
        }
    }

    private function dataFragmentHandler($text): string
    {
        $value = $this->getValue($text['content']);
        //если это информация о фото
        if (gettype($value) === 'array' && isset($value['image_type']) && isset($value['picture'])) {
            $src = 'data:image/' . $value['image_type'] . ';base64,' . $value['picture'];
            $value = '<img class="float-photo" src="' . $src . '"/>';
        }
//
//                            //если это дата ли
//                            if (gettype($value) === 'string' && strpos($value, '.000Z')) {
//                                $date = DateTime::createFromFormat('Y-m-d', substr($value, 0, 10));
//                                $value = $date->format('d.m.Y');
//                            }

        if (!$value)
            $value = '';
        //обработка функциями
        if ($value !== '' && isset($text['functions']))
            foreach ($text['functions'] as $function)
                $value = TextHandlers::$function($value);
        return $value;
    }

    private function htmlFragmentHandler(string $content, $cycleData)
    {
        processResizer($content, $this->formattingInfo);

        $onceString = getFirstTeg($content, 'once');
        if ($onceString)
            $onceString .= '<br>';

        $functionsString = getFirstTeg($content, 'functions');
        $functionArray = [];
        if ($functionsString)
            foreach (explode(';', $functionsString) as $val) {
                $tmpArr = explode('~', $val);
                $functionArray[trim($tmpArr[0])] =
                    array('arg' => trim($tmpArr[1]), 'val' => trim($tmpArr[2]));
            }

        $template = getFirstTeg($content, 'body');
        if (!$template)
            $template = $content;

        $value = '';

        //для циклического варианта заменим источник данных, для вложенных циклов пока реализован только первый уровень
        $data = !isset($cycleData) || $cycleData === ''
            ? [$this->data]
            : (strpos($cycleData, '.')
                ? getNestedCycleData($this->data, $cycleData)
                : $this->data[$cycleData]);

        //получим список используемых полей и заменим на данные
        preg_match_all('#\$(.*?)\$#su', $template, $matches);
        $fields = $matches[1];

        foreach ($data as $currentData) {
            $value .= $onceString;
            $onceString = '';

            $currentValue = $template;
            foreach ($fields as $field) {
                $currentValue = str_replace('$' . $field . '$',
                    dataOperationHandler($field, $currentData, $functionArray), $currentValue);
            }
            $value .= $currentValue;
        }

        if (str_contains($value, '$eagle')) {
            $value = str_replace(
                '$eagle',
                file_get_contents(
                    base_path() . '\resources\images\eagle.svg'),
                $value);
        }

        //Извлечем и используем стили
        preg_match_all('#<head>(.*?)</head>#su', $content, $htmlStyle);
        if (count($htmlStyle[1])) {
            preg_match_all('#<style>(.*?)</style>#su', $htmlStyle[1][0], $htmlStyle);
            $this->htmlStyles .= $htmlStyle[1][0];
        } else {
            $this->htmlStyles .= getFirstTeg($content, 'style');
        }

        return $value;
    }

    private function paragraph($paragraph)
    {
        if (isset($paragraph['displayCondition']) && $paragraph['displayCondition']) {
            $arr = explode('.', $paragraph['displayCondition']);
            $result = $this->data;
            foreach ($arr as $item)
                $result = $result[$item];

            if (!$result || $result === '')
                return;
        }

        $paragraphStyleName = $paragraph['style'];
        $paragraphStyle = null;
        $isFloat = false;
        foreach ($this->template["generalStyles"] as $item) {
            if ($item['name'] === $paragraphStyleName && $item['alignment'] === 'float') {
                $isFloat = true;
                $paragraphStyle = $item;
                break;
            }
        }

        if (!$isFloat) {
            $val = "";
            foreach ($paragraph["content"] as $text) {

                switch ($text['type']) {
                    case 'data':
                        $value = $this->dataFragmentHandler($text);
                        break;
                    case 'html':
                        $value = $this->htmlFragmentHandler($text['content'], $text['cycleData']);
                        break;
                    default:
                        $value = $text['content'];
                }

                $style = $text['style'];

                if (!$style) {
                    $val .= $value;
                } else {
                    $val .= "<span class=\"{$style}\">{$value}</span>";
                }
            }

            if ($text['type'] !== 'html') {
                if (strpos($val, "\n")) {
                    $valArr = explode("\n", $val);
                    foreach ($valArr as $item) {
                        $this->content .= "<p class=\"{$paragraphStyleName}\">" . $item . "</p>";
                    }
                } else {
                    $this->content .= $val === '' ? "<br/>" : "<p class=\"{$paragraphStyleName}\">" . $val . "</p>";
                }
            } else
                $this->content .= $value;

        } else { // isFloat
            $handleElement = function ($element) {
                $value = $element['type'] === 'data' ? $this->getValue($element['content']) : $element['content'];
                if (isset($element['functions'])) {
                    foreach ($element['functions'] as $function) {
                        $value = TextHandlers::$function($value);
                    }
                }
                $style = $element['style'];
                return $style === null ? $value : "<span class=\"{$style}\">{$value}</span>";
            };

            $valuesWithoutLast = "";
            $count = count($paragraph["content"]);
            for ($i = 0; $i < $count - 1; ++$i) {
                $valuesWithoutLast .= $handleElement($paragraph["content"][$i]);
            }

            $lastValue = $handleElement($paragraph["content"][$count - 1]);

            if ($valuesWithoutLast === '')
                $this->content .= $lastValue;
            else
                $this->content .=
                    "<div align=\"left\" style=\"width: 50%;float: left;font-size:{$paragraphStyle['fontSize']}pt\">{$valuesWithoutLast}</div>
<div align=\"right\" style=\"width: 50%;float: right;font-size:{$paragraphStyle['fontSize']}pt\">{$lastValue}</div>";
        }
    }

    private
    function table($value)
    {
        $paragraphStyle = $value['style'];
        $domain = "";
        $fields = [];
        foreach ($value["content"] as $text) {
            $indexDot = strpos($text['content'], ".");
            if ($domain === '')
                $domain = substr($text['content'], 0, $indexDot);
            $fields[] = substr($text['content'], $indexDot + 1);
        }
        foreach ($this->data[$domain] as $row) {
            $val = "";
            foreach ($fields as $field) {
                $val .= $row[$field] . "&nbsp;";
            }
            $this->content .= "<p class=\"{$paragraphStyle}\">$val</p>";
        }
    }

    public
    function getHTML(): string
    {
//        $photo = DB::table('photos')->find(42);
//        $src = 'data:image/' . $photo->image_type . ';base64,' . $photo->picture;
//        $stylesheet = $this->getStyles() . "
//        .container{
//    text-align: justify
//}
//        .montainer{
//    text-align: justify
//}
//.floated{
//    float: right;
//    width: 150px;
//    margin: 5px;
//}";
//        $body = $this->getBody() . "
//        <p class=\"container\">
//    <img class=\"floated\" src=\"{$src}\"/>
//    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
//</p>
//       ";
        $body = $this->getBody();
        $stylesheet = $this->getStyles();
        $stylesheet .= $this->htmlStyles;
        return "<html><head><style>{$stylesheet}</style></head><body>{$body}</body></html>";
    }
}
