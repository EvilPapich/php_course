<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $status_id
 * @property int $author_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Author[] $opinions
 * @property-read int|null $opinions_count
 * @property-read \App\Models\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Post withoutTrashed()
 * @mixin \Eloquent
 */
class Post extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'title',
    'text',
    'author_id',
    'status_id',
  ];

  public function status() {
    return $this->belongsTo('App\Models\Status');
  }

  public function tags() {
    return $this->belongsToMany('App\Models\Tag');
  }

  public function author() {
    return $this->belongsTo('App\Models\Author');
  }

  public function opinions() {
    return $this->belongsToMany('App\Models\Author', 'post_opinions')
      ->withPivot('value');
  }

  public function comments() {
    return $this->belongsToMany('App\Models\Comment', 'post_comments')
      ->withPivot('reference_id');
  }

  public function popularComment() {
    return $this->belongsToMany('App\Models\Comment', 'post_comments')
      ->join('comment_opinions', function($join) {
        $join->on('comment_opinions.comment_id', '=', 'post_comments.comment_id');
      });
  }
}
