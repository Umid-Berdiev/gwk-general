<?php

namespace App\Http\Controllers;

use App\Models\General\InfoLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }


  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $logGidromet = DB::table('info_log')
      ->whereIn('type',[1,2,3])
      ->select(DB::raw('count(*)'),DB::raw('DATE(created_at) as date'))
      ->groupBy('date')
      ->orderBy('date','asc')
      ->limit(10)
      ->get()
      ->toArray();

    $dataGidro = [];
    foreach ($logGidromet as $value) {
      $dataGidro ['date'][] =  date('d.m.Y',strtotime($value->date));
      $dataGidro ['count'][] =  $value->count;
    }

    $logMinvadxoz = DB::table('info_log')
      ->whereIn('type',[4,5])
      ->select(DB::raw('count(*)'),DB::raw('DATE(created_at) as date'))
      ->groupBy('date')
      ->orderBy('date','asc')
      ->limit(10)
      ->get()
      ->toArray();

    $dataMin = [];
    foreach ($logMinvadxoz as $value) {
      $dataMin ['date'][] =  date('d.m.Y',strtotime($value->date));
      $dataMin ['count'][] =  $value->count;
    }

    $logGidroGeologiya = DB::table('info_log')
      ->whereIn('type',[4,5])
      ->select(DB::raw('count(*)'),DB::raw('DATE(created_at) as date'))
      ->groupBy('date')
      ->orderBy('date','asc')
      ->limit(10)
      ->get()
      ->toArray();

    $dataGeo = [];
    foreach ($logGidroGeologiya as $value) {
      $dataGeo ['date'][] =  date('d.m.Y',strtotime($value->date));
      $dataGeo ['count'][] =  $value->count;
    }




    return view('general.pages.dashboard',compact(
      'dataGidro',
      'dataMin',
      'dataGeo'));
  }

}
