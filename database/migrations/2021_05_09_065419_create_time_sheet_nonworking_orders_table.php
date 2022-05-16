<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeSheetNonworkingOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_sheet_nonworking_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('time_sheet_id');
            $table->unsignedInteger('nonworking_order_day');
            $table->foreign('time_sheet_id')->references('id')->on('time_sheets');
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('documents');
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
        Schema::dropIfExists('time_sheet_nonworking_orders');
    }
}
