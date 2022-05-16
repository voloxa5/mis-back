<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update4InterruptionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interruption_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('ratifying_employee_id')->nullable();
            $table->foreign('ratifying_employee_id')->references('id')->on('employee_instances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
