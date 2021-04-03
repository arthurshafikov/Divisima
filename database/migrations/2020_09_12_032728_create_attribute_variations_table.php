<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_variations', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('attribute_id')->unsigned();

            $table->foreign('attribute_id')
                ->references('id')->on('attributes')
                ->onDelete('cascade');
            
            $table->string('name');
            
            $table->string('slug')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_variations');
    }
}
