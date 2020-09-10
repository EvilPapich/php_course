<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
          $table->bigIncrements('id');

          $table->string('lname');
          $table->string('fname');

          $table->unsignedBigInteger('user_id');
          $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('authors');
    }
}
