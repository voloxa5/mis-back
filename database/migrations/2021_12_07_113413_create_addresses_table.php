<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('district_id')->nullable();
            $table->foreign('district_id')->references('id')-> on('dict_districts');
            $table->integer('region_id')->nullable();
            $table->foreign('region_id')->references('id')-> on('dict_regions');
            $table->integer('street_id');
            $table->foreign('street_id')->references('id')-> on('dict_streets');
            $table->string('house',10);
            $table->string('building',10)->nullable();
            $table->string('apartment ',10)->nullable();
            $table->string('note')->nullable();

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
        Schema::dropIfExists('addresses');
    }
}
