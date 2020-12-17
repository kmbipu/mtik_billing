<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrepaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prepaids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('router_id');
            $table->unsignedBigInteger('plan_id');
            $table->date('start_dt');
            $table->date('expire_dt');
            $table->integer('status')->default(0);//0=inactive, 1=active
            $table->timestamps();
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('router_id')
            ->references('id')
            ->on('routers')
            ->onDelete('cascade');
            $table->foreign('plan_id')
            ->references('id')
            ->on('plans')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prepaids');
    }
}
