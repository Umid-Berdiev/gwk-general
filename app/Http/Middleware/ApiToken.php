<?php

namespace App\Http\Middleware;

use Closure;

class ApiToken
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
    if ($request->api_token != config('app.API_KEY')) {
      return response()->json('Please log in', 401);
    }

    return $next($request);
  }
}
