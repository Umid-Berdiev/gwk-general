<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Localization
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
    // $user = Auth::user();
    // if (Session::has('locale')) {
    //   if (Auth::check()) {
    //     App::setLocale($user->lang_prefix);
    //   }
    // } else {
    //   if (Auth::check()) {
    //     if ($user->lang_prefix == null)
    //       Session::put('locale', App::getLocale());
    //     else {
    //       Session::put('locale', $user->lang_prefix);
    //       App::setLocale($user->lang_prefix);
    //     }
    //   }
    // }
    if (session()->has('locale')) {
      app()->setLocale(session('locale'));
    }
    return $next($request);
  }
}
