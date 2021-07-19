<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
