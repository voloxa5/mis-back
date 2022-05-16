<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheets', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->integer('year');
            $table->unsignedBigInteger('employees_unit_id');
            $table->foreign('employees_unit_id')->references('id')->on('employees_units');
            $table->unsignedBigInteger('ratifying_id')->nullable();
            $table->foreign('ratifying_id')->references('id')->on('employees');
            $table->string('ratifying_name', 30)->nullable();
            $table->unsignedBigInteger('ratifying_post_id')->nullable();
            $table->foreign('ratifying_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('ratifying_rank_id')->nullable();
            $table->foreign('ratifying_rank_id')->references('id')->on('dict_ranks');
            $table->unsignedBigInteger('performer_id')->nullable();
            $table->foreign('performer_id')->references('id')->on('employees');
            $table->string('performer_name', 30)->nullable();
            $table->unsignedBigInteger('performer_post_id')->nullable();
            $table->foreign('performer_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('performer_rank_id')->nullable();
            $table->foreign('performer_rank_id')->references('id')->on('dict_ranks');
            $table->dateTime('perform_date')->nullable();
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
        Schema::drop('time_sheets');
    }
}
