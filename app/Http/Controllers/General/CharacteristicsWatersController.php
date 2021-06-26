<?php

namespace App\Http\Controllers\General;

use App\Models\General\CharacteristicsWaters;
use App\Models\General\Chemicals;
use App\Models\General\ListPosts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CharacteristicsWatersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // dd($request->all());
    $user_resource_types = getUserResourceTypes();
    $selected_year = $request->selected_year;

    if (auth()->user()->org_name == 'gidromet' || auth()->user()->org_name == 'other') {
      $posts_lists = ListPosts::where('isDelete', false)->get();
      $chemicals = Chemicals::where('isDelete', false)->get();
      $last_update_date = CharacteristicsWaters::select('updated_at', 'user_id', 'is_approve', 'years')->where('years', $selected_year)->orderBy('updated_at', 'DESC')->first();

      $character_waters = CharacteristicsWaters::where('years', $selected_year)->with('post_list', 'chimicil_list')->paginate(10);
      return view('general.pages.resources.characteristics_water.characteristics_water', [
        'character_waters' => $character_waters,
        'posts_lists' => $posts_lists,
        'chemicals' => $chemicals,
        'selected_year' => $selected_year,
        'selected_type_value' => $request->selected_type_value,
        'average_excess' => $request->average_excess,
        'date_observation' => $request->date_observation,
        'excess_ratio' => $request->excess_ratio,
        'user_resource_types' => $user_resource_types,
        'last_update' => $last_update_date
      ]);
    } else {
      return abort(404);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // dd($request->all());
    $request->validate([
      'post_place' => 'required',
      'chemicals' => 'required',
      'average_excess' => 'required',
      'date_observation' => 'required',
      'excess_ratio' => 'required',
      'selected_year' => 'required',
    ]);

    $characters = new CharacteristicsWaters();
    $characters->list_posts_id = $request->post_place;
    $characters->chemicals_id = $request->chemicals;
    $characters->average_excess = $request->average_excess;
    $characters->date_observation = $request->date_observation;
    $characters->excess_ratio = $request->excess_ratio;
    $characters->years = $request->selected_year;
    $characters->user_id = auth()->id();
    $characters->is_approve = false;
    $characters->save();

    return redirect()->back();
  }
}
