<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;

class AppAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (!$request->hasHeader('x-user-id')) {
        abort(403);
      }

      $userId = $request->header('x-user-id');

      if (!UserService::authorization($userId)) {
        abort(401);
      }

      return $next($request);
    }
}
