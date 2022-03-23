<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\General\InfoLog;
use App\Models\Minvodxoz\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

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

    $data = GidrometData::where("year", $request->year)
      ->with("gidromet_average", "station", "parameter")
      ->orderBy("station_id", "asc")
      ->orderBy("parameter_id", "asc")
      ->get()
      ->toArray();

    return $this->sendResponse($data, 'Режим гидропоста');
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

      $response = Curl::to(config('app.gidrometApiReport1'))
        ->withData([
          'api_token' => config('app.gidrometApiKey'),
          'month' => $selected_date,
        ])
        ->get();
      $response = json_decode($response, true);

      if ($response && isset($response['success'])) {
        $getForm = $response['data']['formObjects'];
        $allDatas = $response['data']['result'];
      }

      $formObjects = [];
      foreach ($getForm as $value){
        $formObjects [] = [
            "id"            => $value['id'] ?? null,
            "gvk_object_id" => $value['gvk_object_id'] ?? null,
            "order_number"  => $value['order_number'] ?? null,
            "check"         => $value['check'] ?? null,
            "year"          => $value['year'] ?? null,
            "created_at"    => $value['created_at'] ?? null,
            "updated_at"    => $value['updated_at'] ?? null,
            "number"        => $value['object']['number'] ?? null,
            "name"          => $value['object']['name'] ?? null,
            "form_id"       => $value['object']['form_id'] ?? null,
            "unit_id"       => $value['object']['unit_id'] ?? null,
            "type_id"       => $value['object']['type_id'] ?? null,
            "get"           => $value['object']['get'] ?? null,
            "set"           => $value['object']['set'] ?? null,
            "obj_id"        => $value['object']['obj_id'] ?? null,
            "name_ru"       => $value['object']['name_ru'] ?? null,
          ];
      }

      foreach ($allDatas as $infor) {
        $key = $infor['gvk_object_id'] . '_' . date('d_m_Y', strtotime($infor['date']));
        $result[] = [
          'date' => $infor['date'],
          'value' => $infor['value'],
          'average' => $infor['average'],
          'form_id' => $infor['form_id'],
          'gvk_object_id' => $infor['gvk_object_id'],
          $key => $infor['value'],
          $key . '_sr' => $infor['average'],
          $key . '_id' => $infor['id'],
        ];
      }
      $log = new InfoLog();
      $log->type = InfoLog::TYPE_AMU;
      $log->save();

      $data = [
        'result' => $result,
        'formObjects' => $formObjects,
      ];
      return $this->sendResponse($data, 'Оператив Амударё');
    }

    // 2) Оператив Сирдарё
    if ($selected_element == "operativeSird") {
      $result = [];
      $objectId = [];

      $response = Curl::to(config('app.gidrometApiReport2'))
        ->withData([
          'api_token' => config('app.gidrometApiKey'),
          'month' => $selected_date,
        ])
        ->get();
      $response = json_decode($response, true);

      if ($response && isset($response['success'])) {
        $getForm = $response['data']['formObjects'];
        $allDatas = $response['data']['result'];
      }

      $formObjects = [];
      foreach ($getForm as $value){
        $formObjects [] = [
          "id"            => $value['id'] ?? null,
          "gvk_object_id" => $value['gvk_object_id'] ?? null,
          "order_number"  => $value['order_number'] ?? null,
          "check"         => $value['check'] ?? null,
          "year"          => $value['year'] ?? null,
          "created_at"    => $value['created_at'] ?? null,
          "updated_at"    => $value['updated_at'] ?? null,
          "number"        => $value['object']['number'] ?? null,
          "name"          => $value['object']['name'] ?? null,
          "form_id"       => $value['object']['form_id'] ?? null,
          "unit_id"       => $value['object']['unit_id'] ?? null,
          "type_id"       => $value['object']['type_id'] ?? null,
          "get"           => $value['object']['get'] ?? null,
          "set"           => $value['object']['set'] ?? null,
          "obj_id"        => $value['object']['obj_id'] ?? null,
          "name_ru"       => $value['object']['name_ru'] ?? null,
        ];
      }

      foreach ($allDatas as $infor) {
        $key = $infor['gvk_object_id'] . '_' . date('d_m_Y', strtotime($infor['date']));
        // $result[$key] = $infor->average;
        // $result[$key . '_sr'] = $infor->value;
        // $result[$key . '_id'] = $infor->id;

        $result[] = [
          'date' => $infor['date'],
          'value' => $infor['value'],
          'average' => $infor['average'],
          'form_id' => $infor['form_id'],
          'gvk_object_id' => $infor['gvk_object_id'],
          //'object' => $infor->object,
          $key => $infor['value'],
          $key . '_sr' => $infor['average'],
          $key . '_id' => $infor['id'],
        ];
      }

      $log = new InfoLog();
      $log->type = InfoLog::TYPE_SIR;
      $log->save();

      $data = [
        'result' => $result,
        'formObjects' => $formObjects,
      ];

      return $this->sendResponse($data, 'Оператив Сирдарё');
    }

    // 3) Режим гидропоста
    if ($selected_element == "rejimGidro") {
      $r_year = date('Y', strtotime($selected_date.'-01'));
      $response = Curl::to(config('app.gidrometApiReport3'))
        ->withData([
          'api_token' => config('app.gidrometApiKey'),
          'year' => $r_year,
        ])
        ->get();
      $response = json_decode($response, true);
      foreach ($response['data'] as $value) {
        $average = $value['gidromet_average'] ?? null;
        $allDatas [] = [
          'january' => (float)($average['I'] ?? null),
          'february' => (float)($average['II'] ?? null),
          'march' => (float)($average['III'] ?? null),
          'april' => (float)($average['IV'] ?? null),
          'may' => (float)($average['V'] ?? null),
          'june' => (float)($average['VI'] ?? null),
          'july' => (float)($average['VII'] ?? null),
          'august' => (float)($average['VIII'] ?? null),
          'september' => (float)($average['IX'] ?? null),
          'october' => (float)($average['X'] ?? null),
          'november' => (float)($average['XI'] ?? null),
          'decamber' => (float)($average['XII'] ?? null),
          'station_id' => (float)($average['XII'] ?? null),
          'parameter_id' => (float)($average['XII'] ?? null),
          'year' => $value['year'] ?? null,
          'station_name' => ($value['station']['station_name'] ?? null),
          'id' => $value['id'] ?? null,
          'param_name' => ($value['parameter']['param_name'] ?? null),
        ];
      }
      $data = [
        'formObjects' => $allDatas
      ];

      $log = new InfoLog();
      $log->type = InfoLog::TYPE_REJIM_GIDRO;
      $log->save();

      return $this->sendResponse($data, 'Режим Гидропост');
    }

    return back()->with('warning', 'Not Found!');
  }
}
