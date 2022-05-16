<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Неправильно, необходимо проверить существует ли таблица
        Schema::dropIfExists('missions');
        //
        Schema::create('missions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('deadline')->nullable();
            $table->date('perform_date')->nullable();
            $table->bigInteger('performer_id')->unsigned()->nullable();
            $table->foreign('performer_id')->references('id')->on('employees');
            $table->bigInteger('answerable_id')->unsigned()->nullable();
            $table->foreign('answerable_id')->references('id')->on('employees');
            $table->bigInteger('director_id')->unsigned()->nullable();
            $table->foreign('director_id')->references('id')->on('employees');
            $table->date('setting_date')->nullable();
            $table->string('title', 80)->nullable();
            $table->string('reason', 255)->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('mission_status_id')->unsigned()->nullable();
            $table->foreign('mission_status_id')->references('id')->on('dict_mission_statuses');
            $table->text('confirmation_info')->nullable();
            $table->bigInteger('confirmation_document_id')->unsigned()->nullable();
            $table->foreign('confirmation_document_id')->references('id')->on('documents');
            $table->bigInteger('priority')->unsigned()->nullable();
            $table->date('viewed_date')->nullable();
            $table->unsignedBigInteger('mission_source_id')->nullable();
            $table->foreign('mission_source_id')->references('id')->on('dict_mission_sources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missions');
    }
}
