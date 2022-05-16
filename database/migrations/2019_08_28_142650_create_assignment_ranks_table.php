<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_ranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('assignment_date');
            $table->date('order_date');
            $table->string('order_number', 10);
            $table->bigInteger('rank_id')->unsigned();
            $table->foreign('rank_id')->references('id')->on('dict_ranks');
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
        Schema::dropIfExists('assignment_ranks');
    }
}
