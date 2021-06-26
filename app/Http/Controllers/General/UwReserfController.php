<?php

namespace App\Http\Controllers\General;

use App\Models\General\RiverFlowRecources;
use App\Models\General\UiReserfs;
use App\Models\General\Wateruse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UwReserfController extends Controller
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

    if (auth()->user()->org_name == 'gidrogeologiya' || auth()->user()->org_name == 'other') {
      $uw_resers  = UiReserfs::where('years', $request->selected_year)->count();
      $last_update_date = UiReserfs::select('updated_at', 'user_id', 'is_approve', 'years')
        ->where('years', $request->selected_year)
        ->orderBy('updated_at', 'DESC')
        ->first();

      if ($uw_resers == 0) {
        foreach ($region_names as $region_name) {
          $uw_reserfs = new UiReserfs();
          $uw_reserfs->region_name = $region_name;
          $uw_reserfs->years = $request->selected_year;
          $uw_reserfs->user_id = auth()->id();
          $uw_reserfs->is_approve = false;
          $uw_reserfs->save();
        }

        $uw_resers = UiReserfs::where('years', $request->selected_year)->orderby('id', 'ASC')->get();

        return view('general.pages.resources.uw_reserfs.uw_reserf', [
          'uw_reserfs' => $uw_resers,
          'selected_year' => $request->selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      } else {
        $uw_resers = UiReserfs::where('years', $request->selected_year)->orderby('id', 'ASC')->get();
        return view('general.pages.resources.uw_reserfs.uw_reserf', [
          'uw_reserfs' => $uw_resers,
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
      case "total":
        UiReserfs::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'total' => $request->param]);
        break;
      case 'surface_water':
        UiReserfs::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'surface_water' => $request->param]);
        break;
      case 'ex_reserf':
        UiReserfs::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'ex_reserf' => $request->param]);
        break;
    }

    return response()->noContent();
  }

  public function accept(Request $request)
  {
    if (auth()->user()->org_name == 'gidrogeologiya') {
      UiReserfs::where('years', $request->get('year'))->update(['user_id' => auth()->id(), 'is_approve' => true]);
    }

    return redirect()->back();
  }
}
