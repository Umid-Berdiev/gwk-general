<?php

namespace App\Http\Middleware;


use Illuminate\Http\Request;

class DataExchangeRole
{
  public function handle(Request $request, \Closure $next)
  {
    if (isset(auth()->user()->roleName->name) && in_array(auth()->user()->roleName->name, ['Administrator', 'Data_exchange'])) {
      return $next($request);
    }
    abort(404);
  }
}
