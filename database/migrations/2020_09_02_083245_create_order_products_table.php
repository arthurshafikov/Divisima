<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->bigInteger('order_id')->unsigned();

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');

            $table->string('qty')->default(0);
            $table->string('size')->nullable();
            $table->string('color')->nullable();

            $table->string('subtotal')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
