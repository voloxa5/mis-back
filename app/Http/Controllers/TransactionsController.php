<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class TransactionsController
{
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    public function rollBack()
    {
        DB::rollBack();
    }

    public function commit()
    {
        DB::commit();
    }
}
