<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActualEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30);
            $table->string('surname', 30);
            $table->string('patronymic', 30);
            $table->string('callsign', 3);
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('dict_posts');
            $table->bigInteger('rank_id')->unsigned();
            $table->foreign('rank_id')->references('id')->on('dict_ranks');
            $table->bigInteger('working_id')->unsigned();
            $table->foreign('working_id')->references('id')->on('dict_yes_nos');
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::dropIfExists('actual_employees');
    }
}
