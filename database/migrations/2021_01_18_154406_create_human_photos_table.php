<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('human_id')->unsigned();
            $table->foreign('human_id')->references('id')->on('humans');
            $table->bigInteger('photo_id')->unsigned();
            $table->foreign('photo_id')->references('id')->on('photos');
            $table->integer('is_basic')->unsigned();
            $table->date('dob')->nullable();
            $table->text('info')->nullable();

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
        Schema::dropIfExists('human_photos');
    }
}
