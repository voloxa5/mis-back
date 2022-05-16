<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictTaskVehicleRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_task_vehicle_roles', function (Blueprint $table) {
            $table->id('id');
            $table->string('value', 30);
            $table->integer('creator')->nullable();
            $table->integer('updater')->nullable();
            $table->tinyInteger('visible');
            $table->unsignedBigInteger('kaskad_id')->nullable();
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
        Schema::dropIfExists('dict_task_vehicle_roles');
    }
}
