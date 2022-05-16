<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('alias_name', 10)->nullable();
            $table->string('number', 10)->nullable();
            $table->bigInteger('work_direction_id')->unsigned()->nullable();
            $table->foreign('work_direction_id')->references('id')->on('dict_work_directions');
            $table->time('reg_date')->nullable();
            $table->text('need_know_information')->nullable();
            $table->text('memorandum')->nullable();
            $table->string('initiator_full_name', 30)->nullable();
            $table->string('initiator_phone', 12)->nullable();
            $table->string('revocation_form_number', 10)->nullable();
            $table->integer('day_count')->nullable();
            $table->string('ratifying_name', 30)->nullable();
            $table->bigInteger('ratifying_post_id')->unsigned()->nullable();
            $table->foreign('ratifying_post_id')->references('id')->on('dict_posts');
            $table->bigInteger('ratifying_rank_id')->unsigned()->nullable();
            $table->foreign('ratifying_rank_id')->references('id')->on('dict_ranks');
            $table->bigInteger('performer_id')->unsigned()->nullable();
            $table->foreign('performer_id')->references('id')->on('employees');
            $table->unsignedTinyInteger('urgent')->nullable();
            $table->tinyInteger('completed')->nullable();
            $table->tinyInteger('in_archive')->nullable();
            $table->unsignedSmallInteger('days_actually_worked')->nullable();
            $table->unsignedSmallInteger('identified_persons')->nullable();
            $table->unsignedSmallInteger('identified_addresses')->nullable();
            $table->unsignedSmallInteger('photos')->nullable();

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
        Schema::dropIfExists('tasks');
    }
}
