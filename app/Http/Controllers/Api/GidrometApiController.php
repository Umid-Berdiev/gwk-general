<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GidrometApiController extends Controller
{
  public function operAmu(Request $request)
  {
    if (!isset($request->month)) {
      return $this->sendError('Please send month!', ['error' => 'Please send month!'], 200);
    }

    $result = [];
    $objectId = [];
    $r_year = date('Y', strtotime($request->month));
    $r_month = date('n', strtotime($request->month));

    $formObjects = OperAmuForm::where('year', $r_year)->where('check', 1)->with('object')->orderBy('order_number')->get();
    //dd($formObjects);
    foreach ($formObjects as $object) {
      $objectId[] = $object->gvk_object_id;
    }

    $allDatas = Information::whereIn('gvk_object_id', $objectId)
      ->whereYear('date', $r_year)
      ->whereMonth('date', $r_month)
      ->with('object')
      ->orderByRaw("updated_at DESC, date ASC")
      ->get();

    foreach ($allDatas as $infor) {
      /*$key = $infor->gvk_object_id . '_' . date('d_m_Y', strtotime($infor->date) );
            $result[$key] = $infor->average;
            $result[$key . '_sr'] = $infor->value;
            $result[$key . '_id'] = $infor->id;*/

      $result[] = [
        'date' => $infor->date,
        'value' => $infor->value,
        'average' => $infor->average,
        'form_id' => $infor->form_id,
        'gvk_object_id' => $infor->gvk_object_id,
        'object' => $infor->object,
      ];
    }

    $data = [
      'result' => $result,
      'formObjects' => $formObjects,
    ];

    return $this->sendResponse($data, 'Оператив Амударё');
  }

  public function operSird(Request $request)
  {
    if (!isset($request->month)) {
      return $this->sendError('Please send month!', ['error' => 'Please send month!'], 200);
    }

    $result = [];
    $objectId = [];
    $r_year = date('Y', strtotime($request->month));
    $r_month = date('n', strtotime($request->month));

    $formObjects = OperSirdForm::where('year', $r_year)->where('check', 1)->with('object')->orderBy('order_number')->get();
    foreach ($formObjects as $object) {
      $objectId[] = $object->gvk_object_id;
    }

    $allDatas = Information::whereIn('gvk_object_id', $objectId)
      ->whereYear('date', $r_year)
      ->whereMonth('date', $r_month)
      ->with('object')
      ->orderByRaw("updated_at DESC, date ASC")
      ->get();

    foreach ($allDatas as $infor) {
      /*$key = $infor->gvk_object_id . '_' . date('d_m_Y', strtotime($infor->date) );
            $result[$key] = $infor->average;
            $result[$key . '_sr' ] = $infor->value;
            $result[$key . '_id'] = $infor->id;*/
      $result[] = [
        'date' => $infor->date,
        'value' => $infor->value,
        'average' => $infor->average,
        'form_id' => $infor->form_id,
        'gvk_object_id' => $infor->gvk_object_id,
        'object' => $infor->object,
      ];
    }

    $data = [
      'result' => $result,
      'formObjects' => $formObjects,
    ];

    return $this->sendResponse($data, 'Оператив Сирдарё');
  }

  public function hydropostMode(Request $request)
  {
    if (!isset($request->year)) {
      return $this->sendError('Please send year!', ['error' => 'Please send year!'], 200);
    }

    $stations = Station::with('datas.gidromet_average')->get();
    $parameters = GidrometParameter::with('gidrometDatas.gidromet_average')->get();
    $data = GidrometData::where("year", $request->year)
      ->with("gidromet_average", "station", "parameter")
      ->orderBy("station_id", "asc")
      ->orderBy("parameter_id", "asc")
      ->get()
      ->toArray();
    //$data = GidrometData::where("station_id", $request->station_id)->where("parameter_id", $request->parameter_id)->with("gidromet_average")->orderBy("year", "DESC")->get();

    return $this->sendResponse($data, 'Режим гидропоста');
    //return $this->sendResponse(\DB::connection()->getDatabaseName(), 'Режим гидропоста');
  }

  protected function getInstanceElementData(Request $request)
  {
    // return $request->all();
    $selected_date = $request->selected_date;
    $selected_element = $request->selected_element;

    $r_year = date('Y', strtotime($selected_date));
    $r_month = date('n', strtotime($selected_date));
    $r_days_in_month = date('t', strtotime($selected_date)); // shu oyda necha kun borligi


    // 1) Оператив Амударё
    if ($selected_element == "operativeAmu") {
      $result = [];
      $objectId = [];

      $formObjects = DB::table('oper_amu_forms')->where('year', $r_year)->where('check', 1)->orderBy('order_number')->join('gvk_objects', 'oper_amu_forms.gvk_object_id', '=', 'gvk_objects.id')->get();
      // return $formObjects;
      // return response()->json($formObjects);

      foreach ($formObjects as $object) {
        $objectId[] = $object->gvk_object_id;
      }
      // return $objectId;

      $allDatas = DB::table('information')->whereIn('gvk_object_id', $objectId)
        ->whereYear('date', $r_year)
        ->whereMonth('date', $r_month)
        // ->orderByRaw("updated_at DESC, date ASC")
        ->join('gvk_objects', 'information.gvk_object_id', '=', 'gvk_objects.id')
        ->get();

      $data = [
        'result' => $allDatas,
        'formObjects' => $formObjects,
      ];

      return $this->sendResponse($data, 'Оператив Амударё');
    }

    // 2) Оператив Сирдарё
    if ($selected_element == "operativeSird") {
      $result = [];
      $objectId = [];

      $formObjects = DB::table('oper_sird_forms')->where('year', $r_year)->where('check', 1)->orderBy('order_number')->join('gvk_objects', 'oper_sird_forms.gvk_object_id', '=', 'gvk_objects.id')->get();
      // return $formObjects;
      // return response()->json($formObjects);

      foreach ($formObjects as $object) {
        $objectId[] = $object->gvk_object_id;
      }
      // return $objectId;

      $allDatas = DB::table('information')->whereIn('gvk_object_id', $objectId)
        ->whereYear('date', $r_year)
        ->whereMonth('date', $r_month)
        // ->orderByRaw("updated_at DESC, date ASC")
        ->join('gvk_objects', 'information.gvk_object_id', '=', 'gvk_objects.id')
        ->get();

      $data = [
        'result' => $allDatas,
        'formObjects' => $formObjects,
      ];

      return $this->sendResponse($data, 'Оператив Сирдарё');
    }

    // 3) Режим гидропоста
    if ($selected_element == "rejimGidro") {
      $objectId = [];

      $allDatas = DB::table('rejim_gidropost')
        ->where('year', $selected_date)
        ->join('stations', 'rejim_gidropost.station_id', '=', 'stations.id')
        ->join('gidromet_parameters', 'rejim_gidropost.parameter_id', '=', 'gidromet_parameters.id')
        ->select('rejim_gidropost.*', 'stations.station_name', 'gidromet_parameters.param_name')
        ->get();

      // return $allDatas;

      $data = [
        'formObjects' => $allDatas
      ];

      return $this->sendResponse($data, 'Режим Гидропост');
    }

    return back()->with('warning', 'Not Found!');
  }
}
