<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TimeSheetEmployeeCompensableDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsh_employee_compensable_days', function (Blueprint $table) {
            $table->id();
            $table->integer('hours_number');
            $table->date('day');
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
        Schema::drop('tsh_employee_compensable_days');
    }
}
