<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSheetNonworkingOrderDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheet_nonworking_order_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nonworking_order_day');
            $table->unsignedBigInteger('time_sheet_nonworking_order_id');
            $table->foreign('time_sheet_nonworking_order_id')->references('id')->on('time_sheet_nonworking_orders');

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
        Schema::dropIfExists('time_sheet_nonworking_order_days');
    }
}

