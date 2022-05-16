<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSheetEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheet_employees', function (Blueprint $table) {
            $table->id();
            $table->integer('after_hours_number')->nullable();
            $table->integer('compensated_number')->nullable();
            $table->integer('final_compensable_number')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('surname', 30)->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('dict_ranks');
            $table->unsignedBigInteger('time_sheet_id');
            $table->foreign('time_sheet_id')->references('id')->on('time_sheets');
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
        Schema::drop('time_sheet_employees');
    }
}
