<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperCaseAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_case_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_paper_case_id');
            $table->foreign('group_paper_case_id')->references('id')->on('group_paper_cases');
            $table->unsignedBigInteger('paper_case_access_id');
            $table->foreign('paper_case_access_id')->references('id')->on('dict_paper_case_accesses');
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
        Schema::dropIfExists('paper_case_accesses');
    }
}
