<?php


namespace App\Services;


use App\Models\Post;
use App\Models\Status;
use Carbon\Carbon;

class PostService
{
  public static function getRecentPosts() {
    return collect(
      Post::with(['status','author', 'tags'])
        ->where([
          ['created_at', '>=', Carbon::now()->subDays(7)]
        ])->get()
    );
  }

  public static function writeDraft(Int $authorId, String $title, String $text) {
    $post = Post::create([
      'author_id' => $authorId,
      'title' => $title,
      'text' => $text,
      'status_id' => Status::DRAFT,
    ]);

    $post->save();
  }

  public static function writePost(Int $authorId, String $title, String $text) {
    $post = Post::create([
      'author_id' => $authorId,
      'title' => $title,
      'text' => $text,
      'status_id' => Status::PUBLISHED,
    ]);

    $post->save();
  }

  public static function publishDraft(Int $postId) {
    $post = Post::find($postId);

    $post->status_id = Status::PUBLISHED;

    $post->save();
  }
}