<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaperworkTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paperwork_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 30);
            $table->unsignedTinyInteger('default_type');
            $table->unsignedSmallInteger('guid')->nullable();
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
