<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('header_fee_id');
            $table->integer('city_id');
            $table->integer('quantity_below');
            $table->integer('quantity_above');
            $table->integer('fee_value');
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
        Schema::drop('detail_fees');
    }
}
