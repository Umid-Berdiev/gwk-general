<?php

namespace App\Http\Controllers\General;

use App\Models\General\ChangeWaterReserves;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChangeWaterReservesController extends Controller
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

//    if (auth()->user()->org_name == 'gidromet' || auth()->user()->org_name == 'other') {
      $change_waters = ChangeWaterReserves::where('years', $selected_year)->count();
      $last_update_date = ChangeWaterReserves::select('updated_at', 'user_id', 'is_approve', 'years')->where('years', $selected_year)->orderBy('updated_at', 'DESC')->first();

      if ($change_waters == 0) {
        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Тюямуюнское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Капарас";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Султансанджарское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();


        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Южносурханское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Чимкурганское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Пачкамарское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Каттакурганское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Чарвакское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Тюябугузское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Западный Арнасай";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Аральское море";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_water_reserv = new ChangeWaterReserves();
        $change_water_reserv->lake = "Андижанское";
        $change_water_reserv->years = $selected_year;
        $change_water_reserv->user_id = auth()->id();
        $change_water_reserv->is_approve = false;
        $change_water_reserv->save();

        $change_waters = ChangeWaterReserves::where('years', $selected_year)->orderby('id', 'asc')->get();
        return view('general.pages.resources.change_water_reserves.change_water_reserves', [
          'change_waters' => $change_waters,
          'selected_year' => $selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      } else {
        $change_waters = ChangeWaterReserves::where('years', $selected_year)->orderby('id', 'asc')->get();
        return view('general.pages.resources.change_water_reserves.change_water_reserves', [
          'change_waters' => $change_waters,
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
      case "average_water_volume":
        ChangeWaterReserves::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'average_water_volume' => $request->param]);
        break;
      case 'average_long_term_level':
        ChangeWaterReserves::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'average_long_term_level' => $request->param]);
        break;
      case 'water_supply':
        ChangeWaterReserves::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'water_supply' => $request->param]);
        break;
      case 'annual_change':
        ChangeWaterReserves::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'annual_change' => $request->param]);
        break;
      case 'water_level':
        ChangeWaterReserves::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'water_level' => $request->param]);
        break;
      case 'change_for_year':
        ChangeWaterReserves::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'change_for_year' => $request->param]);
        break;
    }
  }

  public function accept(Request $request)
  {
    if (auth()->user()->org_name == 'gidromet') {
      $resources = ChangeWaterReserves::where('years', $request->get('year'))->update(['user_id' => auth()->id(), 'is_approve' => true]);
    }

    return redirect()->back();
  }
}
