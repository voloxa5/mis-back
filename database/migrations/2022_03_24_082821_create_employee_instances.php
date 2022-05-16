<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_instances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('surname', 30);
            $table->string('callsign', 3)->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('dict_ranks');
            $table->unsignedBigInteger('working_id')->nullable();
            $table->foreign('working_id')->references('id')->on('dict_yes_nos');
            $table->unsignedBigInteger('employees_unit_id')->unsigned()->nullable();
            $table->foreign('employees_unit_id')->references('id')->on('employees_units');
            $table->date('valid_from');
            $table->date('valid_until');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_instances');
    }
}
