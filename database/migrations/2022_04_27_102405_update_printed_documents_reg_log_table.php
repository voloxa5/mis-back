<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePrintedDocumentsRegLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printed_documents_reg_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('paperwork_type_id')->nullable();
            $table->foreign('paperwork_type_id')->references('id')->on('paperwork_types');
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
