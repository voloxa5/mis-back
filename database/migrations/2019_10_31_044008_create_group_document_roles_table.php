<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupDocumentRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_document_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_dict_document_role')->unsigned();
            $table->foreign('id_dict_document_role')->references('id')->on('dict_document_roles');
            $table->bigInteger('id_group_document')->unsigned();
            $table->foreign('id_group_document')->references('id')->on('group_documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_document_roles');
    }
}
