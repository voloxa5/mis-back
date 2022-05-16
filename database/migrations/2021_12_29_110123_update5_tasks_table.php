<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Update5TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedSmallInteger('days_actually_worked')->nullable();
            $table->unsignedSmallInteger('identified_persons')->nullable();
            $table->unsignedSmallInteger('identified_addresses')->nullable();
            $table->unsignedSmallInteger('photos')->nullable();
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
