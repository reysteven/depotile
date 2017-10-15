<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_header_id');
            $table->integer('item_id');
            $table->string('item_name');
            $table->integer('detail_category_id');
            $table->string('img_name1');
            $table->string('img_name2');
            $table->string('img_name3');
            $table->integer('price_per_box');
            $table->string('type');
            $table->string('hash_code');
            $table->string('parent_hash');
            $table->integer('total_item');
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
        Schema::drop('detail_orders');
    }
}
