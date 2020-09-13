<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
          $table->unsignedBigInteger('comment_id');
          $table->foreign('comment_id')->references('id')->on('comments');

          $table->unsignedBigInteger('post_id');
          $table->foreign('post_id')->references('id')->on('posts');

          $table->unsignedBigInteger('author_id');
          $table->foreign('author_id')->references('id')->on('authors');

          $table->unsignedBigInteger('reference_id')->nullable();
          $table->foreign('reference_id')->references('id')->on('comments');

          $table->primary(['comment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
