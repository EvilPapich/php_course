<?php


namespace App\Services;


use App\Models\Author;

class AuthorService
{
  public static function getAuthorByUserId(Int $userId) {
    return collect(
      Author::with(['user'])
        ->where('user_id', $userId)->get()
    )->first();
  }
}