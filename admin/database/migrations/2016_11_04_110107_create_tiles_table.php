<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_code');
            $table->string('item_name');
            $table->integer('detail_category_id');
            $table->string('img_name1');
            $table->string('img_name2');
            $table->string('img_name3');
            $table->string('description');
            $table->double('length');
            $table->double('width');
            $table->double('thickness');
            $table->integer('pcs_per_box');
            $table->string('price_per_m2');
            $table->integer('brand_id');
            $table->integer('calculator');
            $table->integer('installation_id');
            $table->integer('header_fee_id');
            $table->integer('add_on');
            $table->string('add_on_cta');
            $table->string('add_on_title');
            $table->string('add_on_1');
            $table->string('add_on_2');
            $table->string('add_on_3');
            $table->string('add_on_description_1');
            $table->string('add_on_description_2');
            $table->string('add_on_description_3');
            $table->string('detail_tag_data');
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
        Schema::drop('tiles');
    }
}
