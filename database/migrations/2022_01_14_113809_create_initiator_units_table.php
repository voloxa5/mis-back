<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitiatorUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiator_units', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string ('surname',30);
            $table->string ('name',30);
            $table->string ('patronymic',30);
            $table->unsignedBigInteger ('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('dict_ranks');
            $table->string ('dative_surname',30)->nullable();
            $table->unsignedBigInteger ('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('dict_posts');
            $table->string('department',80);
            $table->string ('dative_department',80);
            $table->string ('short_department',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('initiator_units');
    }
}
