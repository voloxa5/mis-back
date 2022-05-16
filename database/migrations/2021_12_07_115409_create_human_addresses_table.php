<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHumanAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('human_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('human_id');
            $table->foreign('human_id')->references('id')->on('humans');
            $table->integer('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->integer('HUMAN_ADDRESS_ROLE_ID');
            $table->foreign('HUMAN_ADDRESS_ROLE_ID')->references('id')->on('dict_human_address_roles');
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
        Schema::dropIfExists('human_addresses');
    }
}
