<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosedPostReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closed_post_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->unsignedBigInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');

            //подписывающий-signer
            $table->unsignedBigInteger('signer_id')->nullable();
            $table->foreign('signer_id')->references('id')->on('employees');
            $table->string('signer_surname', 30)->nullable();
            $table->unsignedBigInteger('signer_post_id')->nullable();
            $table->foreign('signer_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('signer_rank_id')->nullable();
            $table->foreign('signer_rank_id')->references('id')->on('dict_ranks');
            //исполнитель-performer
            $table->unsignedBigInteger('performer_id')->nullable();
            $table->foreign('performer_id')->references('id')->on('employees');
            $table->string('performer_surname', 30)->nullable();
            $table->unsignedBigInteger('performer_post_id')->nullable();
            $table->foreign('performer_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('performer_rank_id')->nullable();
            $table->foreign('performer_rank_id')->references('id')->on('dict_ranks');

            $table->string('observed_place', 99)->nullable();
            $table->date('report_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('close_post_reports');
    }
}
