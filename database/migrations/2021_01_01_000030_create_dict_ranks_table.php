<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_ranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value', 30);
            $table->integer('creator')->nullable();
            $table->integer('updater')->nullable();
            $table->integer('visible');
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
        Schema::dropIfExists('dict_ranks');
    }
}
