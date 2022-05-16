<?php


namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    private function generatePassword(): string
    {
        $scheme = ['wds', 'wsd', 'dws', 'dsw'][rand(0, 3)];

        $specialSymbols = "!@#$%^&*()-_=+[{]};:'\",<.>/?";
        $specialSymbol = substr($specialSymbols, rand(0, strlen($specialSymbols) - 1), 1);

        $digit = strval(rand(0, 9));

        $word = DB::select('SELECT value FROM dict_passwords ORDER BY RANDOM() LIMIT 1')[0]->value;
        $index = rand(0, strlen($word) - 1);
        $word = substr_replace($word, strtoupper($word[$index]), $index, 1);

        $result = '';
        foreach (str_split($scheme) as $char) {
            if ($char === 'w') {
                $result .= $word;
            } else if ($char === 'd') {
                $result .= $digit;
            } else {
                $result .= $specialSymbol;
            }
        }
        return $result;
    }

    public function generate()
    {
        return response($this->generatePassword(), Response::HTTP_OK);
    }

    private function generateList2(int $quarter, int $year)
    {

    }

    public function generateList()
    {
        $quarter = 1;
        $year = 2022;

        $list = DB::select("
select employees.user_id, groups.id group_id, password, groups.name
from (employees
    JOIN groups on employees.user_id = groups.user_id)
         LEFT JOIN (select *
                    from password_operations
                    where password_operations.year = :year
                      and password_operations.quarter = :quarter) p_o on groups.id = p_o.group_id
where employees.working_id = 1
", ['year' => $year, 'quarter' => $quarter]);

        foreach ($list as $item) {

            $password = $item->password ?: $this->generatePassword();
            $id = DB::table('password_operations')->insertGetId([
                'password' => $password,
                'quarter' => $quarter,
                'year' => $year,
                'group_id' => $item->group_id,
                'is_request_not_notification' => 0,
            ]);

            DB::table('documents')->insert([
                'domain_id' => $id,
                'type' => 'text',
                'title' => 'Уведомление об изменении пароля ' . ' ' . $year . ' ' . $quarter . ' ' . $item->name,
                'creator_id' => $item->group_id,
                'owner_id' => $item->group_id,
                'secrecy_degree_id' => 1,
                'secrecy_clause' => 22,
                'subdomains' => '{"PasswordOperation":{"group":null,"documents":null}}',
                'document_definition_id' => 18,
                'report_content' => 'passwordNotification',
                'content' => '<!DOCTYPE HTML>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>title</title>
    <style>
p {
  white-space: pre;
  line-height: 100%
}
.degree {
  font-family: "Times New Roman",sans-serif;
  font-size:10pt;
  margin: 0 0 0 13cm;
  text-indent: 0;
  text-align: center;
}
.title {
   font-family: "Times New Roman",sans-serif;
   font-size:12pt;
   margin: 0 0 0 0;
   text-indent: 0;
   text-align: center;
}
.text {
   font-family: "Times New Roman",sans-serif;
   font-size:12pt;
   margin: 0 0 0 0;
   text-indent: 1.25cm;
   text-align: justify;
}
</style>
  </head>
  <body>
  <p class="degree">конфиденциально<br/>экз. №1<br/>п.23<br/><br/></p>
  <p class="title">Уведомление о смене пароля<br/><br/></p>
  <p class="text">Реквизиту доступа \'пароль\' пользователя \'user1\' в 1-м квартале 2022 года  присвоено значение \'' . $password . '\'.<br/>
</p>
</body>
</html>'
            ]);
        }

        return response('Пароли сгенерированы', Response::HTTP_OK);
    }
}
