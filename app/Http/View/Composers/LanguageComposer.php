<?php

namespace App\Http\View\Composers;

use App\Models\Additional\Language;
use Illuminate\View\View;

class LanguageComposer
{
  public function compose(View $view)
  {
    $view->with('languages', Language::orderBy('language_name')->get());
  }
}
