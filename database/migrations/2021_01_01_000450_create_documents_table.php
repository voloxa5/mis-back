<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('type', 10);
            $table->string('title', 80);
            $table->binary('content')->nullable();
            $table->bigInteger('domain_type_id')->unsigned();
            $table->foreign('domain_type_id')->references('id')->on('domains');
            $table->bigInteger('domain_id')->unsigned();
            $table->string('mn', 10)->nullable();
            $table->string('reg_number', 10)->nullable();
            $table->dateTime('reg_date')->nullable();
            $table->string('order_number', 10)->nullable();
            $table->dateTime('order_date')->nullable();
            $table->bigInteger('creator_id')->unsigned();
            $table->foreign('creator_id')->references('id')->on('groups');
            $table->bigInteger('owner_id')->unsigned()->nullable();
            $table->foreign('owner_id')->references('id')->on('groups');
            $table->bigInteger('sender_id')->unsigned()->nullable();
            $table->foreign('sender_id')->references('id')->on('groups');
            $table->bigInteger('addressee_id')->unsigned()->nullable();
            $table->foreign('addressee_id')->references('id')->on('groups');
            $table->bigInteger('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms');
            $table->bigInteger('template_id')->unsigned();
            $table->foreign('template_id')->references('id')->on('templates');
            $table->bigInteger('secrecy_degree_id')->unsigned();
            $table->foreign('secrecy_degree_id')->references('id')->on('dict_secrecy_degrees');
            $table->string('secrecy_clause', 10)->unsigned();
            $table->integer('general_domain_storage')->unsigned();
            $table->bigInteger('document_definition_id')->unsigned();
            $table->foreign('document_definition_id')->references('id')->on('document_definitions');
            $table->dateTime('print_date')->nullable();
            $table->bigInteger(' who_printed_id')->unsigned()->nullable();
            $table->foreign('who_printed_id')->references('id')->on('employees');
            $table->unsignedBigInteger('document_type_id')->nullable();
            $table->foreign('document_type_id')->references('id')->on('dict_document_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
