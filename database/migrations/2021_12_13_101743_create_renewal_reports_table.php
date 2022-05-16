<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('conciliator_id')->nullable();
            $table->foreign('conciliator_id')->references('id')->on('employees');
            $table->string('conciliator_surname', 30)->nullable();
            $table->unsignedBigInteger('conciliator_post_id')->nullable();
            $table->foreign('conciliator_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('conciliator_rank_id')->nullable();
            $table->foreign('conciliator_rank_id')->references('id')->on('dict_ranks');

            $table->unsignedBigInteger('signer_id')->nullable();
            $table->foreign('signer_id')->references('id')->on('employees');
            $table->string('signer_surname', 30)->nullable();
            $table->unsignedBigInteger('signer_post_id')->nullable();
            $table->foreign('signer_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('signer_rank_id')->nullable();
            $table->foreign('signer_rank_id')->references('id')->on('dict_ranks');

            $table->unsignedBigInteger('performer_id')->nullable();
            $table->foreign('performer_id')->references('id')->on('employees');
            $table->string('performer_surname', 30)->nullable();
            $table->unsignedBigInteger('performer_post_id')->nullable();
            $table->foreign('performer_post_id')->references('id')->on('dict_posts');
            $table->unsignedBigInteger('performer_rank_id')->nullable();
            $table->foreign('performer_rank_id')->references('id')->on('dict_ranks');

            $table->date('renewal_date')->nullable();
            $table->date('report_date')->nullable();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renewal_reports');
    }
}
