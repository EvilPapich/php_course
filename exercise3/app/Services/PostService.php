<?php


namespace App\Services;


use App\Models\Post;
use Carbon\Carbon;

class PostService
{
  public static function getRecentPosts() {
    return collect(
      Post::where([
        ['created_at', '>=', Carbon::now()->subDays(7)]
      ])
    );
  }
}