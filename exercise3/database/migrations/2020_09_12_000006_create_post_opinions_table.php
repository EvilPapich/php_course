<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostOpinionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_opinions', function (Blueprint $table) {
          $table->unsignedBigInteger('post_id');
          $table->foreign('post_id')->references('id')->on('posts');

          $table->unsignedBigInteger('author_id');
          $table->foreign('author_id')->references('id')->on('authors');

          $table->primary(['post_id', 'author_id']);

          $table->integer('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_opinions');
    }
}
