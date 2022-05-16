<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update5DocumentDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_definitions', function (Blueprint $table) {
            $table->unsignedBigInteger('secrecy_degree_id')->nullable();
            $table->foreign('secrecy_degree_id')->references('id')->on('dict_secrecy_degrees');
            $table->string('secrecy_clause', 10)->nullable();
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
