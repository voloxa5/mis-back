<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update8DocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dateTime('document_reg_date')->nullable();
            $table->unsignedSmallInteger('document_reg_number')->nullable();
            $table->unsignedBigInteger('document_reg_log_id')->nullable();
            $table->foreign('document_reg_log_id')->on('document_registration_logs')->references('id');
            $table->unsignedBigInteger('printed_documents_reg_log_id')->nullable();
            $table->foreign('printed_documents_reg_log_id')->on('printed_documents_reg_logs')->references('id');
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
