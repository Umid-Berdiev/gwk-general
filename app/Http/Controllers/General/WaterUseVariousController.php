<?php

namespace App\Http\Controllers\General;

use App\Models\General\WaterUseVariousNeeds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WaterUseVariousController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user_resource_types = getUserResourceTypes();
    $selected_year = $request->selected_year;
    $region_names = getRegionNames();

//    if (auth()->user()->org_name == 'minvodxoz' || auth()->user()->org_name == 'other') {
      $water_use_needs = WaterUseVariousNeeds::where('years', $selected_year)->count();
      $last_update_date = WaterUseVariousNeeds::select('updated_at', 'user_id', 'is_approve', 'years')->where('years', $selected_year)->orderBy('updated_at', 'DESC')->first();

      if ($water_use_needs == 0) {
        foreach ($region_names as $region_name) {
          $resource_regions = new WaterUseVariousNeeds();
          $resource_regions->region_name = $region_name;
          $resource_regions->years = $selected_year;
          $resource_regions->user_id = auth()->id();
          $resource_regions->is_approve = false;
          $resource_regions->save();
        }

        $water_use_needs = WaterUseVariousNeeds::orderby('id', 'ASC')->get();

        return view('general.pages.resources.water_user_variouse_needs.water_user_variouse_needs', [
          'water_use_needs' => $water_use_needs,
          'selected_year' => $selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      } else {
        $water_use_needs = WaterUseVariousNeeds::where('years', $selected_year)->orderby('id', 'ASC')->get();
        return view('general.pages.resources.water_user_variouse_needs.water_user_variouse_needs', [
          'water_use_needs' => $water_use_needs,
          'selected_year' => $selected_year,
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
      case "from_surface_sources":
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'from_surface_sources' => $request->param]);
        break;
      case 'from_underground_sources':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'from_underground_sources' => $request->param]);
        break;
      case 'total':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'total' => $request->param]);
        break;
      case 'irrigation':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'irrigation' => $request->param]);
        break;
      case 'industry':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'industry' => $request->param]);
        break;
      case 'utilities':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'utilities' => $request->param]);
        break;
      case 'fisheries':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'fisheries' => $request->param]);
        break;
      case 'irrevocably_energy':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'irrevocably_energy' => $request->param]);
        break;
      case 'other':
        WaterUseVariousNeeds::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'other' => $request->param]);
        break;
    }
  }

  public function accept(Request $request)
  {
    if (auth()->user()->org_name == 'minvodxoz') {
      WaterUseVariousNeeds::where('years', $request->get('year'))->update(['user_id' => auth()->id(), 'is_approve' => true]);
    }

    return redirect()->back();
  }
}
