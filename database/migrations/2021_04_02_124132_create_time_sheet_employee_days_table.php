<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSheetEmployeeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheet_employee_days', function (Blueprint $table) {
            $table->id();
            $table->integer('hours_number');
            $table->integer('day');
            $table->string('code', 3);
            $table->date('from_time');
            $table->date('to_time');
            $table->date('explanatory_date');
            $table->unsignedBigInteger('time_sheet_employee_id');
            $table->foreign('time_sheet_employee_id')->references('id')->on('time_sheet_employees');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('time_sheet_employee_days');
    }
}
