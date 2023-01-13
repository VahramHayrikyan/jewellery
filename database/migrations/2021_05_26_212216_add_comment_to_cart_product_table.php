<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentToCartProductTable extends Migration
{
    public function up()
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('unit_price');
        });
    }

    public function down()
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }
}
