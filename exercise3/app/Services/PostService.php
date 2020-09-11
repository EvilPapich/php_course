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
          ['created_at', '>=', Carbon::now()->subDays(7)],
          ['status_id', '=', Status::PUBLISHED]
        ])
        ->orderByDesc('created_at')->get()
    );
  }

  public static function writeDraft(Int $authorId, String $title, String $text, ?Array $tags) {
    $post = Post::create([
      'author_id' => $authorId,
      'title' => $title,
      'text' => $text,
      'status_id' => Status::DRAFT,
    ]);

    $post->save();

    $dbTags = TagService::mergeTags($tags);

    foreach ($dbTags as $tag) {
      $post->tags()->attach($tag['id']);
    }

    $post->save();
  }

  public static function writePost(Int $authorId, String $title, String $text, ?Array $tags) {
    $post = Post::create([
      'author_id' => $authorId,
      'title' => $title,
      'text' => $text,
      'status_id' => Status::PUBLISHED,
    ]);

    $post->save();

    $dbTags = TagService::mergeTags($tags);

    foreach ($dbTags as $tag) {
      $post->tags()->attach($tag['id']);
    }

    $post->save();
  }

  public static function publishDraft(Int $postId) {
    $post = Post::find($postId);

    $post->status_id = Status::PUBLISHED;

    $post->save();
  }
}