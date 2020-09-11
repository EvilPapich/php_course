<?php


namespace App\Http\Controllers;


use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController
{
  public function getAuthor(Request $request) {
    $userId = $request->header('x-user-id');

    $author = AuthorService::getAuthorByUserId($userId);

    return json_encode($author);
  }
}