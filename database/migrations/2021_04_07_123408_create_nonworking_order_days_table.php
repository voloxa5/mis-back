<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonworkingOrderDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nonworking_order_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('day');
            $table->unsignedInteger('holiday_or_weekend');
            $table->unsignedBigInteger('nonworking_order_id');
            $table->foreign('nonworking_order_id')->references('id')->on('nonworking_orders');

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
        Schema::dropIfExists('nonworking_order_days');
    }
}
