<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number')->nullable();
            $table->dateTimeTz('start_time')->nullable();
            $table->dateTimeTz('end_time')->nullable();
            $table->bigInteger('was_observed_id')->unsigned()->nullable();
            $table->foreign('was_observed_id')->references('id')->on('dict_yes_nos');
            $table->text('supervision_condition')->nullable();
            $table->bigInteger('supervision_id')->unsigned()->nullable();
            $table->foreign('supervision_id')->references('id')->on('supervisions');
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
        Schema::dropIfExists('shifts');
    }
}
