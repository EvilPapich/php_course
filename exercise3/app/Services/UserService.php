<?php


namespace App\Services;


use App\Models\User;

class UserService
{
  public static function authentication(String $login, String $password) {
    $result = collect(
      User::where([
        ['name', '=', $login],
        ['password', '=', $password],
      ])->get()
    );

    if ($result->count() === 1) {
      return collect([
        'result' => true,
        'userId' => $result->first()->id,
      ]);
    } else {
      return collect([
        'result' => false,
        'userId' => null,
      ]);
    }
  }

  public static function authorization(Int $userId) {
    $result = collect(
      User::where('id', $userId)->get()
    );

    return $result->count() === 1;
  }
}