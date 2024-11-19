<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetectedGasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detected_gases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('formula');
            $table->string('mass_concentration')->nullable();
            $table->string('volume_fraction')->nullable();
            $table->integer('product_id')->index('product_id');
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
        Schema::dropIfExists('detected_gases');
    }
}