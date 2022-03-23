<?php

namespace App\Http\Controllers\General;

use App\Models\General\AmuSirForms;
use App\Models\General\DailyHistory;
use App\Models\General\InfoLog;
use App\Models\General\InformationHistory;
use App\Models\Minvodxoz\GvkObject;
use App\Models\Minvodxoz\ReservoirMonthlyDatas;
use App\Models\Gidromet\RejimGidropost;
use App\Models\Gidrogeologiya\GidrogeologiyaWellData;
use App\Models\Gidrogeologiya\GidrogeologiyaPlaceBirth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;

class DataExchangeController extends Controller
{
  const TYPE_API = 'data-api';
  const TYPE_BASE = 'data-base';

  public function index()
  {
    $instances = $this->getInstances();
    return view('general.data-exchange.index', compact('instances'));
  }

  protected function getInstanceElements(Request $request)
  {
    if ($request->instance == trans('messages.Gidromet')) {
      return [
        trans("messages.Operative Amu"),
        trans("messages.Operative Sird"),
        trans("messages.Rejim Gidro")
      ];
    }
    if ($request->instance == trans('messages.Minvodxoz')) {
      return [
        trans("messages.Every Day Datas"),
        trans("messages.Volume month reservoir")
      ];
    }
    if ($request->instance == trans('messages.Gidrogeologiya')) {
      return [
        trans("messages.Place birth"),
        trans("messages.Well")
      ];
    } else return [];
  }

  protected function getInstanceElementData(Request $request)
  {
    $instances = $this->getInstances();
    $selected_date = $request->selected_date;
    $selected_element = $request->selected_element;
    $selected_instance = $request->selected_instance;
    $action = $request->action;

    $r_year = date('Y', strtotime($selected_date));
    $r_month = date('n', strtotime($selected_date));
    $r_days_in_month = date('t', strtotime($selected_date)); // shu oyda necha kun borligi
    $response = null;

    // 1) Оператив Амударё
    if ($selected_element == trans("messages.Operative Amu")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.gidrometApiReport1'))
          ->withData([
            'api_token' => config('app.gidrometApiKey'),
            'month' => $selected_date,
          ])
          ->get();
        $response = json_decode($response, true);
      }
      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {

        /************** informatinga yuklash  *************************/
        if ($action != self::TYPE_BASE) {

         InfoLog::addLog(InfoLog::TYPE_AMU);

          $formObjects = $response['data']['formObjects'];
          $allDatas = $response['data']['result'];

        } else {
          $formObjects = AmuSirForms::where('year', $r_year)->where('check', 1)
            ->where('type', AmuSirForms::TYPE_AMU)
            ->with('object')
            ->orderBy('order_number')
            ->get()
            ->toArray();
          $objectId = array_column($formObjects, 'gvk_object_id');
          $allDatas = InformationHistory::where('type', AmuSirForms::TYPE_AMU)
            ->whereIn('gvk_object_id', $objectId)
            ->get()
            ->toArray();
        }

        $result = [];
        foreach ($allDatas as $infor) {
          $key = $infor['gvk_object_id'] . '_' . date('d_m_Y', strtotime($infor['date']));
          $result[$key] = $infor['value'];
          $result[$key . '_sr'] = $infor['average'];
          $result[$key . '_id'] = $infor['id'];
        }
        return view('general.data-exchange.amu', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'result',
          'formObjects',
          'r_month',
          'r_year',
          'r_days_in_month',
          'action',
        ));
      }
    } // 2) Оператив Сирдарё
    elseif ($selected_element == trans("messages.Operative Sird")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.gidrometApiReport2'))
          ->withData([
            'api_token' => config('app.gidrometApiKey'),
            'month' => $selected_date,
          ])
          ->get();
        $response = json_decode($response, true);
      }
      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {

        if ($action != self::TYPE_BASE) {
          $formObjects = $response['data']['formObjects'];
          $allDatas = $response['data']['result'];
          InfoLog::addLog(InfoLog::TYPE_SIR);
        } else {
          $formObjects = AmuSirForms::where('year', $r_year)->where('check', 1)
            ->where('type', AmuSirForms::TYPE_SIR)
            ->with('object')
            ->orderBy('order_number')
            ->get()
            ->toArray();
          $objectId = array_column($formObjects, 'gvk_object_id');
          $allDatas = InformationHistory::where('type', AmuSirForms::TYPE_SIR)
            ->whereIn('gvk_object_id', $objectId)
            ->get()
            ->toArray();
        }
        $result = [];
        foreach ($allDatas as $infor) {
          $key = $infor['gvk_object_id'] . '_' . date('d_m_Y', strtotime($infor['date']));
          $result[$key] = $infor['average'];
          $result[$key . '_sr'] = $infor['value'];
          $result[$key . '_id'] = $infor['id'];
        }

        return view('general.data-exchange.sird-oper', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'result',
          'formObjects',
          'r_month',
          'r_year',
          'r_days_in_month',
          'action',
        ));
      }
    } // 3) Режим гидропоста
    elseif ($selected_element == trans("messages.Rejim Gidro")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.gidrometApiReport3'))
          ->withData([
            'api_token' => config('app.gidrometApiKey'),
            'year' => $r_year,
          ])
          ->get();
        $response = json_decode($response, true);
      }

      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {
        if($action != self::TYPE_BASE) {
          $allDatas = $response['data'];
          InfoLog::addLog(InfoLog::TYPE_REJIM_GIDRO);
        } else {
          $allDatas = RejimGidropost::where("year", $r_year)
            ->with("station", "parameter")
            ->orderBy("station_id", "asc")
            ->orderBy("parameter_id", "asc")
            ->get()
            ->toArray();

            // dd($selected_element);
            return view('general.data-exchange.gidro-base', compact(
              'instances',
              'selected_instance',
              'selected_element',
              'selected_date',
              'allDatas',
              'action',
              'r_year'
            ));
        }
        return view('general.data-exchange.gidro', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'action',
          'r_year'
        ));
      }
    } // 4) Ежедневные
    elseif ($selected_element == trans("messages.Every Day Datas")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.minvodxozApiReport4'))
          ->withData([
            'api_token' => config('app.minvodxozApiKey'),
            'month' => $selected_date,
          ])
          ->post();
        $response = json_decode($response, true);
      }

      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {
        if($action != self::TYPE_BASE) {
          $allDatas = $response['data'];
          $day = date('d_m_Y', strtotime($selected_date . '-01'));
          if (!empty($allDatas)) {
            $firstData = $allDatas[$day];
          }
          InfoLog::addLog(InfoLog::TYPE_MIN_DAILY);
        }else {
          $day = date('Y-m-d', strtotime($selected_date . '-01'));
          $totalResult = DailyHistory::whereYear('dateCr',$r_year)
            ->whereMonth('dateCr',$r_month)
            ->orderBy('dateCr','asc')
            ->orderBy('object_id','desc')
            ->get()
            ->toArray();

          if (!empty($totalResult)) {
            $firstData = DailyHistory::where('dateCr',$day)
              ->orderBy('object_id','desc')
              ->get()
              ->toArray();
          }
          foreach ($totalResult as $value){
            $allDatas[date('d_m_Y', strtotime($value['dateCr']))][] = $value;
          }
        }
        return view('general.data-exchange.daily', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'r_month',
          'r_year',
          'allDatas',
          'firstData',
          'action',
        ));
      }
    } // 5) Объемы в/х месячные
    elseif ($selected_element == trans("messages.Volume month reservoir")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.minvodxozApiReport5'))
          ->withData([
            'api_token' => config('app.minvodxozApiKey'),
            'year' => $r_year,
          ])
          ->post();
        $response = json_decode($response, true);
      }
      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {
        if($action != self::TYPE_BASE){
          $allDatas = $response['data'];
          InfoLog::addLog(InfoLog::TYPE_MIN_RECO);
        }else {
          $getData = ReservoirMonthlyDatas::where('year',$r_year)
            ->get();

          $objects = GvkObject::whereIn('id',array_column($getData->toArray(),'object_id'))
            ->select('gvk_objects.id','gvk_objects.name as object_name')
            ->get()
            ->toArray();
          foreach ($objects as $value){
              $model = $getData->filter(function ($item) use ($value) {
                return $item->object_id == $value['id'];
              })->first();

            $allDatas [] = [
              'id' => $value['id'],
              'object_id' => $value['id'],
              'object_name' => $value['object_name'],
              'object_datas' => $model->toArray(),
            ];
          }
        }
        return view('general.data-exchange.reservoir', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'r_month',
          'r_year',
          'action',
        ));
      }
    } // 6) Место рождение
    elseif ($selected_element == trans("messages.Place birth")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.gidrogeologiyaApiReport6'))
          ->withData([
            'api_token' => config('app.gidrogeologiyaApiKey'),
            'year' => $r_year,
          ])
          ->get();

        $response = json_decode($response, true);
      }
      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {
        if($action != self::TYPE_BASE){
            $allDatas = $response['data'];
            InfoLog::addLog(InfoLog::TYPE_GIDROFEOLOGIYA_RECO);
        } else {
          $result = GidrogeologiyaPlaceBirth::where('year',$r_year)
            ->get()
            ->toArray();
          foreach ($result as $value)
            $allDatas[]['properties']= $value;
        }
        return view('general.data-exchange.place-birth', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'r_month',
          'r_year',
          'action',
        ));
      }
    }

    // 7) Скважина
    if ($selected_element == trans("messages.Well")) {
      if ($action != self::TYPE_BASE) {
        $response = Curl::to(config('app.gidrogeologiyaApiReport7'))
          ->withData([
            'api_token' => config('app.gidrogeologiyaApiKey'),
            'year' => $r_year,
          ])
          ->get();
        $response = json_decode($response, true);
      }

      if ($response && isset($response['success']) || $action == self::TYPE_BASE) {
        if ($action != self::TYPE_BASE) {
          $allDatas = $response['data'];
          InfoLog::addLog(InfoLog::TYPE_GIDROFEOLOGIYA_WELL);
        }else {
          $allDatas = GidrogeologiyaWellData::where('year' ,$r_year)
              ->get()
              ->toArray();
        }
        return view('general.data-exchange.well-data', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'r_month',
          'r_year',
          'action',
        ));
      }
    }
    return view('general.data-exchange.index', compact(
      'instances',
      'selected_instance',
      'selected_element',
      'selected_date'))->with('warning', 'Not Found!');
  }

  public function saveDataHistorty(Request $request)
  {
    // 1) Оператив Амударё
    if ($request->selected_element == trans("messages.Operative Amu")) {
      InformationHistory::setHistory(json_decode($request->formObjects, true), json_decode($request->allDatas, true), $request->r_year, AmuSirForms::TYPE_AMU);
    } // 2) Оператив Сирдарё
    elseif ($request->selected_element == trans("messages.Operative Sird")) {
      InformationHistory::setHistory(json_decode($request->formObjects, true), json_decode($request->allDatas, true), $request->r_year, AmuSirForms::TYPE_SIR);
    } // 3) Режим гидропоста
    elseif ($request->selected_element == trans("messages.Rejim Gidro")) {
      RejimGidropost::setDatas(json_decode($request->allDatas, true), $request->r_year);
    } // 4) Ежедневные
    elseif ($request->selected_element == trans("messages.Every Day Datas")) {
      DailyHistory::setHistpory(json_decode($request->allDatas, true));
    } // 5) Объемы в/х месячные
    elseif ($request->selected_element == trans("messages.Volume month reservoir")) {
      ReservoirMonthlyDatas::setDatas(json_decode($request->allDatas, true), $request->r_year);
    } // 6) Место рождение
    elseif ($request->selected_element == trans("messages.Place birth")) {
      GidrogeologiyaPlaceBirth::setDatas(json_decode($request->allDatas, true), $request->r_year);
    } // 7) Скважина
    elseif ($request->selected_element == trans("messages.Well")) {
      GidrogeologiyaWellData::setDatas(json_decode($request->allDatas, true), $request->r_year);
    }
    return redirect()->back();
  }

  /**
   * @return array
   */
  private function getInstances()
  {
    return [
      __('messages.Gidromet'),
      __('messages.Minvodxoz'),
      __('messages.Gidrogeologiya'),
    ];
  }

  public function getLogList(Request $request)
  {
      $action = $request->action;
      $selected_element = $request->selected_element;
      $selected_date = $request->selected_date;
      $selected_instance = $request->selected_instance;
      $logs = InfoLog::where('type',$request->type)->paginate(15);
      return view('general.data-exchange.log',compact(
         'selected_element',
         'action',
         'selected_instance',
         'selected_date',
         'logs'
      ));
  }
}
