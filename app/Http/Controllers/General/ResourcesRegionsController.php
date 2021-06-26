<?php

namespace App\Http\Controllers\General;

use App\Models\General\ResourcesRegions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourcesRegionsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user_resource_types = getUserResourceTypes();

    return view('general.pages.resources.index', compact('user_resource_types'));
  }

  public function getTypeData(Request $request)
  {
    $selected_type_value = $request->selected_type_value;
    $selected_year = $request->selected_year;

    switch ($request->selected_type_value) {
      case 1:
        return redirect()->route('resource.resource_regions_with', compact('selected_type_value', 'selected_year'));
      case 2:
        return redirect()->route('resource.uw_reserf', compact('selected_type_value', 'selected_year'));
      case 3:
        return redirect()->route('resource.water_uses', compact('selected_type_value', 'selected_year'));
      case 4:
        return redirect()->route('resource.river_recources', compact('selected_type_value', 'selected_year'));
      case 5:
        return redirect()->route('resource.ground_water', compact('selected_type_value', 'selected_year'));
      case 6:
        return redirect()->route('resource.ground_water_use', compact('selected_type_value', 'selected_year'));
      case 7:
        return redirect()->route('resource.water_use_various_needs', compact('selected_type_value', 'selected_year'));
      case 8:
        return redirect()->route('resource.information_large_canals_irigation_system', compact('selected_type_value', 'selected_year'));
      case 9:
        return redirect()->route('resource.change_water_reserves', compact('selected_type_value', 'selected_year'));
      case 10:
        return redirect()->route('resource.characteristics_water', compact('selected_type_value', 'selected_year'));
    }
  }

  public function indexWith(Request $request)
  {
    // dd($request->all());
    $user_resource_types = getUserResourceTypes();

    $region_names = getRegionNames();

    if (in_array(auth()->user()->org_name, ['gidromet', 'other'])) {
      $resource_with_year = ResourcesRegions::where('years', $request->selected_year)->count();
      if ($resource_with_year == 0) {
        foreach ($region_names as $region_name) {
          $resource_regions = new ResourcesRegions();
          $resource_regions->region_name = $region_name;
          $resource_regions->years = $request->selected_year;
          $resource_regions->user_id = auth()->id();
          $resource_regions->is_approve = false;
          $resource_regions->save();
        }

        $resource_regions = ResourcesRegions::where('years', $request->selected_year)->orderBy('id', 'ASC')->get();
        $last_update_date = ResourcesRegions::select('updated_at', 'user_id', 'is_approve', 'years')
          ->where('years', $request->selected_year)
          ->orderBy('updated_at', 'DESC')
          ->first();

        return view('general.pages.resources.resources_regions.resources_region', [
          'resources' => $resource_regions,
          'selected_year' => $request->selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      } else {
        $resource_regions = ResourcesRegions::where('years', $request->selected_year)->orderBy('id', 'ASC')->get();
        $last_update_date = ResourcesRegions::select('updated_at', 'user_id', 'is_approve', 'years')
          ->where('years', $request->selected_year)
          ->orderBy('updated_at', 'DESC')
          ->first();

        return view('general.pages.resources.resources_regions.resources_region', [
          'resources' => $resource_regions,
          'selected_year' => $request->selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      }
    } else {
      abort(404);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    switch ($request->func) {
      case "average_values":
        ResourcesRegions::where('id', $request->id)->update(['average_values' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case 'highest_values':
        ResourcesRegions::where('id', $request->id)->update(['highest_values' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case 'smallest_value':
        ResourcesRegions::where('id', $request->id)->update(['smallest_value' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case 'local_rows':
        ResourcesRegions::where('id', $request->id)->update(['local_rows' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case 'inflow':
        ResourcesRegions::where('id', $request->id)->update(['inflow' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case 'outflow_outside':
        ResourcesRegions::where('id', $request->id)->update(['outflow_outside' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case 'shared_resources':
        ResourcesRegions::where('id', $request->id)->update(['shared_resources' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
      case "total_row":
        ResourcesRegions::where('id', $request->id)->update(['total_row' => $request->param, 'user_id' => auth()->id(), 'is_approve' => false]);
        break;
    }

    return response()->noContent();
  }

  public function accept(Request $request)
  {
    if (auth()->user()->org_name == 'gidromet') {
      if ($request->get('type') == 'resource') {
        ResourcesRegions::where('years', $request->get('year'))->update(['user_id' => auth()->id(), 'is_approve' => true]);
      }
    }

    return redirect()->back();
  }
}
