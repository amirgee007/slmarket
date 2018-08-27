<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_earnings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('product_order_id');
            $table->dateTime('cleared_at');
            $table->integer('total');
            $table->boolean('cleared')->default(0);
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
        Schema::dropIfExists('user_earnings');
    }
}
