<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update10DocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_marked_delete')->nullable();
            $table->unsignedBigInteger('marked_delete_group_id')->nullable();
            $table->foreign('marked_delete_group_id')->references("id")->on("groups");
            $table->dateTime('marked_delete_date')->nullable();

            $table->dateTime('deletion_date')->nullable();
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
