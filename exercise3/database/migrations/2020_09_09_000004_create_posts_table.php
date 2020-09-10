<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
          $table->bigIncrements('id');

          $table->string('title');
          $table->text('text');

          $table->unsignedBigInteger('status_id');
          $table->foreign('status_id')->references('id')->on('statuses');

          $table->unsignedBigInteger('author_id');
          $table->foreign('author_id')->references('id')->on('authors');

          $table->timestamp('created_at')->useCurrent();
          $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
