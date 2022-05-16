<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonworkingOrderDayShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nonworking_order_day_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('time');
            $table->unsignedBigInteger('nonworking_order_day_id');
            $table->foreign('nonworking_order_day_id')->references('id')->on('nonworking_order_days');

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
        Schema::dropIfExists('nonworking_order_day_shifts');
    }
}
