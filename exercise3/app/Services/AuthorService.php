<?php


namespace App\Services;


use App\Models\Author;

class AuthorService
{
  public static function getAuthorByUserId(Int $userId) {
    return collect(
      Author::where('user_id', $userId)->get()
    )->first();
  }
}