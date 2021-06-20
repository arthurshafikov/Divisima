<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('img')->unsigned()->nullable();
            $table->foreign('img')
                ->references('id')->on('images')
                ->onDelete('set null');
            $table->bigInteger('price');
            $table->enum('stock', ['in_stock', 'pre_order', 'out_of_stock'])->default('in_stock');
            $table->string('description')->nullable();
            $table->string('details')->nullable();

            $table->integer('total_sales')->default(0);

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('products');
    }
}
