<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allproducts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allcategs_id')->constrained();
            $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('rate')->nullable();
            $table->string('mcount')->nullable();
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
        Schema::dropIfExists('allproducts');
    }
}
