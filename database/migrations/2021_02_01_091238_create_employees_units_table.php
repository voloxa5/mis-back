<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title', 25)->nullable();
            $table->integer('unit_level')->nullable();
            $table->integer('subunit_level')->nullable();
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
        Schema::dropIfExists('employees_units');
    }
}
