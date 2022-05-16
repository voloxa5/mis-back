<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update7TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->tinyInteger('completed')->nullable();
            $table->string('addressee_full_name', 30)->nullable();
            $table->unsignedBigInteger('addressee_rank_id')->nullable();
            $table->foreign('addressee_rank_id')->references('id')->on('dict_ranks');
            $table->unsignedBigInteger('addressee_post_id')->nullable();
            $table->foreign('addressee_post_id')->references('id')->on('dict_posts');
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
