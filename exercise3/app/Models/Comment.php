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
    return $this->hasOne('App\Models\Post');
  }

  public function author() {
    return $this->hasOne('App\Models\Author');
  }

  public function reference() {
    return $this->hasOne('App\Models\Comment');
  }

  public function opinions() {
    return $this->belongsToMany('App\Models\Author', 'comment_opinions')
      ->withPivot('value');
  }
}
