<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update3TerminationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('termination_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('conciliator_id')->nullable();
            $table->foreign('conciliator_id')->references('id')->on('employees');
            $table->string('conciliator_surname', 30)->nullable();
            $table->unsignedBigInteger('conciliator_post_id')->nullable();
            $table->foreign('conciliator_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('conciliator_rank_id')->nullable();
            $table->foreign('conciliator_rank_id')->references('id')->on('dict_ranks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
