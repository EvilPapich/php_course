<?php


namespace App\Services;


use App\Models\Post;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class PostService
{
  public static function getRecentPosts() {
    return collect(
      Post::with(['status','author','tags'])
        ->withCount([
          'opinions as likes' => function (Builder $query) {
            $query->where('value', '=', 1);
          },
          'opinions as dislikes' => function (Builder $query) {
            $query->where('value', '=', 0);
          },
        ])
        ->where([
          ['created_at', '>=', Carbon::now()->subDays(7)],
          ['status_id', '=', Status::PUBLISHED]
        ])
        ->orderByDesc('updated_at')->get()
    );
  }

  public static function getDrafts(Int $authorId) {
    return collect(
      Post::with(['status','author', 'tags'])
        ->where([
          ['author_id', '=', $authorId],
          ['status_id', '=', Status::DRAFT],
        ])
        ->orderByDesc('updated_at')->get()
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

  public static function publishDraft(Int $postId, Int $authorId, String $title, String $text, ?Array $tags) {
    $post = Post::where([
      ['id', '=', $postId],
      ['author_id', '=', $authorId],
      ['status_id', '=', Status::DRAFT],
    ])->firstOrFail();

    $post->title = $title;
    $post->text = $text;
    $post->status_id = Status::PUBLISHED;

    $post->save();

    $dbTags = TagService::mergeTags($tags);

    $post->tags()->detach();

    foreach ($dbTags as $tag) {
      $post->tags()->attach($tag['id']);
    }

    $post->save();
  }

  public static function editDraft(Int $postId, Int $authorId, String $title, String $text, ?Array $tags) {
    $post = Post::where([
      ['id', $postId],
      ['author_id', $authorId],
      ['status_id', '=', Status::DRAFT],
    ])->firstOrFail();

    $post->title = $title;
    $post->text = $text;

    $post->save();

    $dbTags = TagService::mergeTags($tags);

    $post->tags()->detach();

    foreach ($dbTags as $tag) {
      $post->tags()->attach($tag['id']);
    }

    $post->save();
  }

  public static function deleteDraft(Int $postId, Int $authorId) {
    $post = Post::where([
      ['id', $postId],
      ['author_id', $authorId],
      ['status_id', '=', Status::DRAFT],
    ])->firstOrFail();

    $post->delete();

    $post->save();
  }

  public static function ratePost(Int $postId, Int $authorId, Int $value) {
    $post = Post::where([
      ['id', $postId],
      ['status_id', '=', Status::PUBLISHED],
    ])->firstOrFail();

    $opinion = collect(
      $post->opinions()->wherePivot('author_id', $authorId)->get()
    );

    if (
      $opinion->count() === 1
      && $opinion->first()->pivot->value === $value
    ) {
      $post->opinions()->detach($authorId);
    } else if (
      $opinion->count() === 1
    ) {
      $post->opinions()->updateExistingPivot($authorId, ['value' => $value]);
    } else {
      $post->opinions()->attach($authorId, ['value' => $value]);
    }

    $post->save();
  }
}