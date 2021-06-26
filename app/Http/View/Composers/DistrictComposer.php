<?php

namespace App\Http\View\Composers;

use App\Models\Additional\UzDistrict;
use Illuminate\View\View;

class DistrictComposer
{
  public function compose(View $view)
  {
    $view->with('uz_districts', UzDistrict::orderBy('nameRu')->select('areaid', 'nameRu', 'regionid')->get()->toArray());
  }
}
