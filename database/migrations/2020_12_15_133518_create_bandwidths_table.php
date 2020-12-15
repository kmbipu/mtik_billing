<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandwidthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidths', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->integer('rate_down');
            $table->string('rate_down_unit',4);
            $table->integer('rate_up');
            $table->string('rate_up_unit',4);
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
        Schema::dropIfExists('bandwidths');
    }
}
