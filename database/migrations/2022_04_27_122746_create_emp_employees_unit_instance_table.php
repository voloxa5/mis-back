<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpEmployeesUnitInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_employees_unit_instances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->unsignedBigInteger('employees_unit_id');
            $table->foreign('employees_unit_id')->references('id')->on('employees_units');
            $table->date('actual_with');
            $table->date('actual_until');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emp_employees_unit_instances');
    }
}
