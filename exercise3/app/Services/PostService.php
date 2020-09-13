<?php


namespace App\Services;


use App\Models\Comment;
use App\Models\Post;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
          ['updated_at', '>=', Carbon::now()->subDays(7)],
          ['status_id', '=', Status::PUBLISHED]
        ])
        ->orderByDesc('updated_at')->get()
    );
  }

  public static function getRecentPostsWithParams(?Array $filters, ?Array $orders, ?Array $tags) {
    if (is_null($filters)) $filters = [[]];
    if (is_null($orders)) $orders = ['updated_at' => 'desc'];
    if (is_null($tags)) $tags = [];

    $filters = array_filter($filters);

    $result = Post::with([
        'status' => function() {},
        'author' => function() {},
        'tags' => function() {},
        'comments' => function (BelongsToMany $query) {
          $query->orderBy('updated_at', 'desc');
        },
        'comments.author' => function () {},
      ])
      ->withCount([
        'opinions as likes' => function (Builder $query) {
          $query->where('value', '=', 1);
        },
        'opinions as dislikes' => function (Builder $query) {
          $query->where('value', '=', 0);
        },
      ])
      ->where(array_merge($filters, [
        ['updated_at', '>=', Carbon::now()->subDays(7)],
        ['status_id', '=', Status::PUBLISHED]
      ]));

    foreach ($tags as $index => $tag) {
      $whereClause = ($index===0 ? "whereHas" : "orWhereHas");

      $result = $result->$whereClause('tags', function(Builder $query) use ($tag) {
        $query->where('tag_id', '=', $tag);
      });
    }

    foreach ($orders as $column => $order) {
      $result = $result->orderBy($column, $order);
    }

    $result = $result->get();

    return collect($result);
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

  public static function writeComment(Int $postId, Int $authorId, ?Int $referenceId, String $message) {
    $post = Post::where([
      ['id', '=', $postId],
      ['status_id', '=', Status::PUBLISHED],
    ])->firstOrFail();

    $comment = Comment::create([
      'message' => $message,
    ]);

    $comment->save();

    $post->comments()->attach($comment->id, [
      'post_id' => $postId,
      'author_id' => $authorId,
      'reference_id' => $referenceId
    ]);

    $post->save();
  }
}