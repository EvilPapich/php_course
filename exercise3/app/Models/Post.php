<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
