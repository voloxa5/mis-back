<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('appointment_date');
            $table->date('order_date');
            $table->string('order_number', 10);
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('dict_posts');
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
        Schema::dropIfExists('assignment_posts');
    }
}
