<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('content');
            $table->string('content_hash',99);
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->on('users')->references('id');
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->on('documents')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_versions');
    }
}
