<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteTreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_trees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->on('groups')->references('id');
            $table->string('tree',4000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_trees');
    }
}
