<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
  use SoftDeletes;

  const PUBLISHED = 1;
  const DRAFT = 2;

  public function posts() {
    return $this->hasMany('App\Models\Post');
  }
}
