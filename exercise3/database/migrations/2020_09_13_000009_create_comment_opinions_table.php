<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentOpinionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_opinions', function (Blueprint $table) {
          $table->unsignedBigInteger('comment_id');
          $table->foreign('comment_id')->references('id')->on('comments');

          $table->unsignedBigInteger('author_id');
          $table->foreign('author_id')->references('id')->on('authors');

          $table->primary(['comment_id', 'author_id']);

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
        Schema::dropIfExists('comment_opinions');
    }
}
