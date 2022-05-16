<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJsonDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('json_domains', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('domain_id')->nullable();
            $table->string('domain',30);
            $table->json('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('json_domains');
    }
}
