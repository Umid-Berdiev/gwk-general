<?php

namespace App\Http\Controllers\General;

use App\Models\Additional\UzRegion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MapController extends Controller
{
  public function index()
  {
    $uz_regions = UzRegion::all();

    return view('general.pages.map.map', [
      'uz_regions' => $uz_regions
    ]);
  }
}
