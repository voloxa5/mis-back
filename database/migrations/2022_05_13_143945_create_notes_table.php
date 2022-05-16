<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('folder_name',40);
            $table->string('name',80);
            $table->string('content',4000);
            $table->unsignedBigInteger('user_changed_id');
            $table->foreign('user_changed_id')->on('users')->references('id');
            $table->unsignedBigInteger('user_created_id');
            $table->foreign('user_created_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
