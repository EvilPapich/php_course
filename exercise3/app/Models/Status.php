<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
  use SoftDeletes;

  public function posts() {
    return $this->belongsToMany('App\Models\Post');
  }
}
