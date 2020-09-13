<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'message',
  ];

  public function post() {
    return $this->belongsToMany('App\Models\Post','post_comments');
  }

  public function author() {
    return $this->belongsToMany('App\Models\Author','post_comments');
  }

  public function reference() {
    return $this->belongsToMany('App\Models\Comment','post_comments');
  }

  public function opinions() {
    return $this->belongsToMany('App\Models\Author', 'comment_opinions')
      ->withPivot('value');
  }
}
