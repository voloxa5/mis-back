<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminationReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termination_reports', function (Blueprint $table) {
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
            //reason-причина прекращения СН
            $table->unsignedBigInteger('reason_type_id')->nullable();
            $table->foreign('reason_type_id')->references('id')->on('dict_term_reason_types');
            //доп. информация
            $table->string('addition', 999)->nullable();
            //по инициативе инициатора
            $table->integer('according_initiator')->nullable();
            //дата прекращения
            $table->date('termination_date')->nullable();

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
        Schema::dropIfExists('termination_reports');
    }
}
