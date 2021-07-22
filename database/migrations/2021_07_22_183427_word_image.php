<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WordImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_image', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('image_id');
            $table->foreign('image_id')->references('id')->on('images');

            $table->bigInteger('word_id');
            $table->foreign('word_id')->references('id')->on('words');

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
        Schema::dropIfExists('word_image');
    }
}
