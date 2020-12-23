<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique();
            $table->unsignedBigInteger('router_id');
            $table->unsignedBigInteger('pool_id');
            $table->unsignedBigInteger('bandwidth_id');
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->integer('validity');
            $table->string('validity_unit',10);
            $table->integer('seller_id');
            $table->integer('is_display')->default(0);
            $table->integer('is_active')->default(0);
            $table->timestamps();
            $table->foreign('router_id')
            ->references('id')
            ->on('routers')
            ->onDelete('restrict');
            $table->foreign('pool_id')
            ->references('id')
            ->on('pools')
            ->onDelete('restrict');
            $table->foreign('bandwidth_id')
            ->references('id')
            ->on('bandwidths')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
