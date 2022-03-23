<?php

namespace App\Http\Controllers\General;

use App\Models\General\Wateruse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WaterUsesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user_resource_types = getUserResourceTypes();
    $region_names = getRegionNames();
    $selected_year = $request->selected_year;

//    if (auth()->user()->org_name == 'gidromet' || auth()->user()->org_name == 'other') {
      $water_uses = Wateruse::where('years', $selected_year)->count();
      $last_update_date = Wateruse::select('updated_at', 'user_id', 'is_approve', 'years')
        ->where('years', $selected_year)
        ->orderBy('updated_at', 'DESC')
        ->first();

      if ($water_uses == 0) {
        foreach ($region_names as $region_name) {
          $uw_reserfs = new Wateruse();
          $uw_reserfs->region_name = $region_name;
          $uw_reserfs->years = $selected_year;
          $uw_reserfs->user_id = auth()->id();
          $uw_reserfs->is_approve = false;
          $uw_reserfs->save();
        }

        $water_uses = Wateruse::where('years', $selected_year)->orderBy('id', 'ASC')->get();

        return view('general.pages.resources.water_uses.water_uses', [
          'water_uses' => $water_uses,
          'selected_year' => $selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      } else {
        $water_uses = Wateruse::where('years', $selected_year)->orderBy('id', 'ASC')->get();
        return view('general.pages.resources.water_uses.water_uses', [
          'water_uses' => $water_uses,
          'selected_year' => $request->selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      }
//    } else {
//      return abort(404);
//    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    switch ($request->func) {
      case "total_km":
        Wateruse::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'total_km' => $request->param]);
        break;
      case 'river_network':
        Wateruse::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'river_network' => $request->param]);
        break;
      case 'inland_rivers':
        Wateruse::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'inland_rivers' => $request->param]);
        break;
      case 'underground_sources':
        Wateruse::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'underground_sources' => $request->param]);
        break;
      case 'from_collector':
        Wateruse::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'from_collector' => $request->param]);
        break;
    }

    return response()->noContent();
  }

  public function accept(Request $request)
  {
    // dd($request->all());
    if (auth()->user()->org_name == 'gidromet') {
      Wateruse::where('years', $request->get('year'))->update(['user_id' => auth()->id(), 'is_approve' => true]);
    }

    return redirect()->back();
  }
}
