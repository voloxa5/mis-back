<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_instructions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('actual_employee_id')->unsigned();
            $table->foreign('actual_employee_id')->references('id')->on('actual_employees');
            $table->bigInteger('shift_id')->unsigned();
            $table->foreign('shift_id')->references('id')->on('shifts');
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
        Schema::dropIfExists('shift_instructions');
    }
}
