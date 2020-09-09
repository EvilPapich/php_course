<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use SoftDeletes;

  public function status() {
    return $this->hasOne('App\Models\Status');
  }

  public function tags() {
    return $this->belongsToMany('App\Models\Tag');
  }

  public function author() {
    return $this->hasOne('App\Models\Author');
  }
}
