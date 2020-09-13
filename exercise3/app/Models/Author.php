<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
  use SoftDeletes;

  public function posts() {
    return $this->hasMany('App\Models\Post');
  }

  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  public function postOpinions() {
    return $this->belongsToMany('App\Models\Post', 'post_opinions')
      ->withPivot('value');
  }

  public function comments() {
    return $this->belongsToMany('App\Models\Comment','post_comments');
  }

  public function commentOpinions() {
    return $this->belongsToMany('App\Models\Comment', 'comment_opinions')
      ->withPivot('value');
  }
}
