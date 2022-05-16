<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictPaperCaseAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_paper_case_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('value', 30);
            $table->integer('creator')->nullable();
            $table->integer('updater')->nullable();
            $table->integer('visible');
            $table->integer('GUID')->nullable();
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
        Schema::dropIfExists('dict_paper_case_accesses');
    }
}
