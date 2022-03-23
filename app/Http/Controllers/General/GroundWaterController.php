<?php

namespace App\Http\Controllers\General;

use App\Models\General\GroundwaterResources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroundWaterController extends Controller
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

      $ground_water = GroundwaterResources::where('years', $selected_year)->count();
      $last_update_date = GroundwaterResources::select('updated_at', 'user_id', 'is_approve', 'years')->where('years', $selected_year)->orderBy('updated_at', 'DESC')->first();

      if ($ground_water == 0) {
        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Ферганский';
        $ground_water->pool_name = 'Бассейн реки Сырдарьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Приташкентский';
        $ground_water->pool_name = 'Бассейн реки Сырдарьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Голодностепский';
        $ground_water->pool_name = 'Бассейн реки Сырдарьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Восточно-Северо-Восточный Кызылкумский';
        $ground_water->pool_name = 'Бассейн реки Сырдарьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Итого';
        $ground_water->pool_name = 'Бассейн реки Сырдарьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Зарафшанский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Кашкадарьинкий';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Сурхандарьинский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Бухара-Турткульский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Левобережье р. Амударьи';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Приаральский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Итого';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Нарата - Туркестанский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Нурата - Туркестанский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Центрально-Кызылкумский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Устюртский';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Итого';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = new GroundwaterResources();
        $ground_water->region_name = 'Республика Узбекистан';
        $ground_water->pool_name = 'Бассейн реки Амударьи';
        $ground_water->years = $selected_year;
        $ground_water->user_id = auth()->id();
        $ground_water->is_approve = false;
        $ground_water->save();

        $ground_water = GroundwaterResources::where('years', $selected_year)->orderBy('id', 'ASC')->get();
        return view('general.pages.resources.ground_water.ground_water', [
          'ground_waters' => $ground_water,
          'selected_year' => $selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      } else {
        $ground_water = GroundwaterResources::where('years', $selected_year)->orderBy('id', 'ASC')->get();
        return view('general.pages.resources.ground_water.ground_water', [
          'ground_waters' => $ground_water,
          'selected_year' => $selected_year,
          'selected_type_value' => $request->selected_type_value,
          'last_update' => $last_update_date,
          'user_resource_types' => $user_resource_types
        ]);
      }
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
      case "natural_resources":
        GroundwaterResources::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'natural_resources' => $request->param]);
        break;
      case 'region_total':
        GroundwaterResources::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'region_total' => $request->param]);
        break;
      case 'including_surface_water':
        GroundwaterResources::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'including_surface_water' => $request->param]);
        break;
      case 'approved_total':
        GroundwaterResources::where('id', $request->id)->update(['user_id' => auth()->id(), 'is_approve' => false, 'approved_total' => $request->param]);
        break;
    }
  }

  public function accept(Request $request)
  {
    if (auth()->user()->org_name == 'gidrogeologiya') {
      GroundwaterResources::where('years', $request->get('year'))->update(['user_id' => auth()->id(), 'is_approve' => true]);
    }
    return redirect()->back();
  }
}
