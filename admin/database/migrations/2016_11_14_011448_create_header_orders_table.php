<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number');
            $table->integer('user_id');
            $table->string('receiver_name');
            $table->string('receiver_address');
            $table->string('receiver_telp1');
            $table->string('receiver_telp2');
            $table->string('user_note');
            $table->string('admin_note');
            $table->integer('fee');
            $table->string('status');
            $table->softDeletes();
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
        Schema::drop('header_orders');
    }
}
