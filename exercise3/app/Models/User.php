<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  use SoftDeletes;

  const USER_ID_HEADER = 'x-user-id';

  public function author() {
    return $this->hasOne('App\Models\Author');
  }
}
