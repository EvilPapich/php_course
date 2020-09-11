<?php


namespace App\Http\Controllers;


use App\Services\UserService;
use Illuminate\Http\Request;

class UserController
{
  public function signIn(Request $request) {
    $body = $request->json();

    $login = $body->get('login');
    $password = $body->get('password');

    $auth = UserService::authentication($login, $password);

    return json_encode($auth);
  }

  public function getUser(Request $request) {
    $userId = $request->header('x-user-id');

    $user = UserService::getUser($userId);

    return json_encode($user);
  }
}