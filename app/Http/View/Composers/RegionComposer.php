<?php

namespace App\Http\View\Composers;

use App\Models\Additional\UzRegion;
use Illuminate\View\View;

class RegionComposer
{
  public function compose(View $view)
  {
    $view->with('uz_regions', UzRegion::orderBy('nameRu')->select('regionid', 'nameRu')->get());
  }
}
