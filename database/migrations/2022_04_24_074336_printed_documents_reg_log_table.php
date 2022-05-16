<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrintedDocumentsRegLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printed_documents_reg_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedSmallInteger('year_of_journal');
            $table->unsignedSmallInteger('reg_number');
            $table->string('title', 255);
            $table->unsignedBigInteger('owner_group_id');
            $table->foreign('owner_group_id')->on('groups')->references('id');
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
