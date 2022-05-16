<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskLegalEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_legal_entities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('legal_entity_id');
            $table->foreign('legal_entity_id')->references('id')->on('legal_entities');
            $table->unsignedBigInteger('task_legal_entity_role_id');
            $table->foreign('task_legal_entity_role_id')->references('id')->on('dict_task_legal_entity_roles');
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
        Schema::dropIfExists('task_legal_entities');
    }
}
