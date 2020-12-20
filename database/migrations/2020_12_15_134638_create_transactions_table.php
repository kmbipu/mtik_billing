<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('username',100);
            $table->string('plan_name',100);
            $table->integer('amount');
            $table->date('start_dt');
            $table->date('expire_dt');
            $table->string('status',50); //pending/complete
            $table->string('type',100); //recharge, transfer(plus or minus amount)
            $table->string('p_method',100); //auto_bkash, manual_bkash, cash
            $table->string('p_trxid',100); 
            $table->string('p_notes',255)->nullable(); //
            $table->integer('reseller_id')->default(0);
            $table->unsignedBigInteger('created_by');            
            $table->timestamps();
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('created_by')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('transactions');
    }
}
