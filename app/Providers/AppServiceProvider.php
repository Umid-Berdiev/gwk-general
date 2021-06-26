<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\DistrictComposer;
use App\Http\View\Composers\LanguageComposer;
use App\Http\View\Composers\RegionComposer;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Paginator::useBootstrap();
    View::composer(['blocks.header', 'admin.terms.index', 'admin.languages.index'], LanguageComposer::class);
    View::composer(['gidromet.pages.reestr.*', 'gidromet.pages.map.*', 'gidromet.pages.contacts.*', 'admin.users.index'], RegionComposer::class);
    View::composer(['gidromet.pages.reestr.*', 'gidromet.pages.map.*', 'gidromet.pages.contacts.*'], DistrictComposer::class);
  }
}
