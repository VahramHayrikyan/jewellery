<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValueCartProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_value_cart_product', function (Blueprint $table) {
            $table->id();
            $table->integer('cart_product_id');
            $table->integer('attribute_value_id');

            $table->unique(['cart_product_id', 'attribute_value_id'], 'cart_attribute_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_value_cart_product');
    }
}
