<?php


namespace App\Http\Controllers;


use App\Services\PostService;
use Illuminate\Http\Request;

class PostController
{
  public function getRecentPosts(Request $request) {
    return PostService::getRecentPosts();
  }
}