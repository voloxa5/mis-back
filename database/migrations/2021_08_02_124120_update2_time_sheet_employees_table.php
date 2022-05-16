<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update2TimeSheetEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_sheet_employees', function (Blueprint $table) {

            $table->unsignedBigInteger('employees_unit_id')->nullable();
            $table->foreign('employees_unit_id')->references('id')->on('employees_units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
