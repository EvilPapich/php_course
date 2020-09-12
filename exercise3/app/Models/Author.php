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

  public function opinions() {
    return $this->belongsToMany('App\Models\Post', 'post_opinions')
      ->withPivot('value');
  }
}
