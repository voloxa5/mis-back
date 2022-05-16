<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{

    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 30)->unique();
            $table->string('description', 250)->nullable();
            $table->json('content')->nullable();
            $table->bigInteger('domain_id')->unsigned();
            $table->foreign('domain_id')->references('id')->on('domains');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
