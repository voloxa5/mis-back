<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30);
            $table->string('surname', 30);
            $table->string('patronymic', 30);
            $table->string('callsign', 3)->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('post_id')->unsigned()->nullable();
            $table->foreign('post_id')->references('id')->on('dict_posts');
            $table->bigInteger('rank_id')->unsigned()->nullable();
            $table->foreign('rank_id')->references('id')->on('dict_ranks');
            $table->bigInteger('working_id')->unsigned();
            $table->foreign('working_id')->references('id')->on('dict_yes_nos');
            $table->bigInteger('sex_id')->unsigned()->nullable();
            $table->foreign('sex_id')->references('id')->on('dict_sexes');
            $table->date('dob')->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('employees_unit_id')->unsigned()->nullable();
            $table->foreign('employees_unit_id')->references('id')->on('employees_units');

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
        Schema::dropIfExists('employees');
    }
}
