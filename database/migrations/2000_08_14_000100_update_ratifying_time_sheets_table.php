<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRatifyingTimeSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_sheets', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
