<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->default(0);
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->text('text');
            $table->tinyInteger('rating');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('reviews');
    }
}
