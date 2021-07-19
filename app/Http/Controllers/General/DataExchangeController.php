<?php

namespace App\Http\Controllers\General;

use App\DailyForm;
use App\Models\Minvodxoz\GvkObject;
use App\Models\Minvodxoz\Information;
use App\Models\Minvodxoz\ReservoirMonthlyDatas;
use App\Models\Gidromet\RejimGidropost;
use App\Models\Gidrogeologiya\GidrogeologiyaWellData;
use App\Models\Gidrogeologiya\GidrogeologiyaPlaceBirth;
use App\NewFormsModel;
use App\OperAmuForm;
use App\OperSirdForm;
use App\ReservoirForms;
use App\Models\Additional\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

class DataExchangeController extends Controller
{
  public function index()
  {
    $instances = $this->getInstances();

    return view('general.data-exchange.index', compact('instances'));
  }

  public function SirdForm(Request $request)
  {
    $year = $request->year;
    if (!(bool)strtotime($year . '-01-01')) {
      return view('data-exchange.error_form', compact(
        'year'
      ));
    }
    $form = OperSirdForm::where('year', $year)->get()->first();
    $form_id = $request->form;
    $elements = $request->elements;
    $month = $request->month;

    if ($form == null) {
      $form = OperSirdForm::orderBy('year', 'desc')->get()->first();
      if ($form != null) {
        $forms = OperSirdForm::where('year', $form->year)->orderBy('order_number')->get();
        $i = 0;
        $array = array();
        foreach ($forms as $value) {
          $i++;
          $new = array(
            'year' => $year,
            'order_number' => $i,
            'check' => 1,
            'gvk_object_id' => $value->gvk_object_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          );
          $array[] = $new;
        }
        if (count($array) > 0) DB::table('oper_sird_forms')->insert($array);
        $forms = OperSirdForm::where('year', $year)->orderBy('order_number')->get();
      }
    } else {
      $forms = OperSirdForm::where('year', $year)->orderBy('order_number')->get();
    }

    $object_id = [];
    $objects = GvkObject::get();
    foreach ($objects as $object) {
      $is_yes = false;
      foreach ($forms as $value) {
        if ($object->id == $value->stat_object_id) $is_yes = true;
      }
      if ($is_yes == false) $object_id[] = $object->id;
    }
    $existObject = GvkObject::whereIn('id', $object_id)->get();
    $allForms = NewFormsModel::get();
    $unitsList = Unit::get();

    return view('general.data-exchange.sird_form', compact(
      'year',
      'existObject',
      'forms',
      'form_id',
      'allForms',
      'unitsList',
      'elements',
      'month'
    ));
  }

  public function deleteObjFromRes(Request $request)
  {
    $res = ReservoirForms::find($request->id);
    $res->delete();
    return back();
  }

  public function deleteObjFromSird(Request $request)
  {
    $sird = OperSirdForm::find($request->id);
    $sird->delete();
    return back();
  }

  public function deleteObjFromAmu(Request $request)
  {
    $amu = OperAmuForm::find($request->id);
    $amu->delete();
    return back();
  }

  public function deleteObjFromDaily(Request $request)
  {
    $daily = DailyForm::find($request->id);
    $daily->delete();
    return back();
  }

  public function AjaxChangeSird(Request $request)
  {
    if ($request->page == 'sird') {
      $sird = OperSirdForm::find($request->id);
      if ($request->field == 'name_ru') {
        $obj = GvkObject::where('id', $sird->gvk_object_id)->get()->first();
        $obj->name_ru = $request->value;
        $obj->save();
      }
      if ($request->field == 'name') {
        $obj = GvkObject::where('id', $sird->gvk_object_id)->get()->first();
        $obj->name = $request->value;
        $obj->save();
      }
      if ($request->field == 'order_number') $sird->order_number = $request->value;
      if ($request->field == 'check') {
        if ($request->value == '1') $sird->check = 1;
        else $sird->check = 0;
      }
      $sird->save();
      return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
    }
    if ($request->page == 'amu') {
      $amu = OperAmuForm::find($request->id);
      if ($request->field == 'name_ru') {
        $obj = GvkObject::where('id', $amu->gvk_object_id)->get()->first();
        $obj->name_ru = $request->value;
        $obj->save();
      }
      if ($request->field == 'name') {
        $obj = GvkObject::where('id', $amu->gvk_object_id)->get()->first();
        $obj->name = $request->value;
        $obj->save();
      }
      if ($request->field == 'order_number') $amu->order_number = $request->value;
      if ($request->field == 'check') {
        if ($request->value == '1') $amu->check = 1;
        else $amu->check = 0;
      }
      $amu->save();
      return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
    }

    if ($request->page == 'reservoir') {
      $reservoir = ReservoirForms::find($request->id);
      if ($request->field == 'name_ru') {
        $obj = GvkObject::where('id', $reservoir->gvk_object_id)->get()->first();
        $obj->name_ru = $request->value;
        $obj->save();
      }
      if ($request->field == 'name') {
        $obj = GvkObject::where('id', $reservoir->gvk_object_id)->get()->first();
        $obj->name = $request->value;
        $obj->save();
      }
      if ($request->field == 'order_number') $reservoir->order_number = $request->value;
      if ($request->field == 'check') {
        if ($request->value == '1') $reservoir->check = 1;
        else $reservoir->check = 0;
      }
      $reservoir->save();
      return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
    }

    if ($request->page == 'daily') {
      $daily = DailyForm::find($request->id);
      if ($request->field == 'name_ru') {
        $obj = GvkObject::where('id', $daily->gvk_object_id)->get()->first();
        $obj->name_ru = $request->value;
        $obj->save();
      }
      if ($request->field == 'name') {
        $obj = GvkObject::where('id', $daily->gvk_object_id)->get()->first();
        $obj->name = $request->value;
        $obj->save();
      }
      if ($request->field == 'order_number') $daily->order_number = $request->value;
      if ($request->field == 'check') {
        if ($request->value == '1') $daily->check = 1;
        else $daily->check = 0;
      }
      if ($request->field == 'morning') {
        if ($request->value == '1') $daily->morning = 1;
        else $daily->morning = 0;
      }
      if ($request->field == 'present') {
        if ($request->value == '1') $daily->present = 1;
        else $daily->present = 0;
      }
      $daily->save();
      return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
    }
  }

  public function AjaxSelectElement(Request $request)
  {
    if ($request->value == '1') {
      echo '<option value="1">' . trans('messages.Operative Amu') . '</option>';
      echo '<option value="2">' . trans('messages.Operative Sird') . '</option>';
      echo '<option value="3">' . trans('messages.Rejim Gidro') . '</option>';
    }

    if ($request->value == '2') {
      echo '<option value="4">' . trans('messages.Every Day Datas') . '</option>';
      echo '<option value="5">' . trans('messages.Volume month reservoir') . '</option>';
    }

    if ($request->value == '3') {
      echo '<option value="6">' . trans('messages.Place birth') . '</option>';
      echo '<option value="7">' . trans('messages.Well') . '</option>';
    }
  }

  public function AmuForm(Request $request)
  {
    $year = $request->year;
    if (!(bool)strtotime($year . '-01-01')) {
      return view('general.data-exchange.error_form', compact(
        'year'
      ));
    }
    $form_id = $request->form;
    $elements = $request->elements;
    $month = $request->month;
    $form = OperAmuForm::where('year', $year)->get()->first();
    if ($form == null) {
      $form = OperAmuForm::orderBy('year', 'desc')->get()->first();
      if ($form != null) {
        $forms = OperAmuForm::where('year', $form->year)->orderBy('order_number')->get();
        $i = 0;
        $array = array();
        foreach ($forms as $value) {
          $i++;
          $new = array(
            'year' => $year,
            'order_number' => $i,
            'check' => 1,
            'gvk_object_id' => $value->gvk_object_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          );
          $array[] = $new;
        }
        if (count($array) > 0) DB::table('oper_amu_forms')->insert($array);
        $forms = OperAmuForm::where('year', $year)->orderBy('order_number')->get();
      }
    } else {
      $forms = OperAmuForm::where('year', $year)->orderBy('order_number')->get();
    }

    $object_id = [];
    $objects = GvkObject::get();
    foreach ($objects as $object) {
      $is_yes = false;
      foreach ($forms as $value) {
        if ($object->id == $value->stat_object_id) $is_yes = true;
      }
      if ($is_yes == false) $object_id[] = $object->id;
    }
    $existObject = GvkObject::whereIn('id', $object_id)->get();

    $allForms = NewFormsModel::get();
    $unitsList = Unit::get();
    return view('general.data-exchange.amu_form', compact(
      'year',
      'existObject',
      'forms',
      'form_id',
      'allForms',
      'unitsList',
      'elements',
      'month'
    ));
  }

  public function ReservoirForm(Request $request)
  {
    $year = $request->year;
    if (!(bool)strtotime($year . '-01-01')) {
      return view('general.data-exchange.error_form', compact(
        'year'
      ));
    }
    $form_id = $request->form;
    $elements = $request->elements;
    $month = $request->month;
    $form = ReservoirForms::where('year', $year)->get()->first();
    if ($form == null) {
      $form = ReservoirForms::orderBy('year', 'desc')->get()->first();
      if ($form != null) {
        $forms = ReservoirForms::where('year', $form->year)->orderBy('order_number')->get();
        $i = 0;
        $array = array();
        foreach ($forms as $value) {
          $i++;
          $new = array(
            'year' => $year,
            'order_number' => $i,
            'check' => 1,
            'gvk_object_id' => $value->gvk_object_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          );
          $array[] = $new;
        }
        if (count($array) > 0) DB::table('reservoir_forms')->insert($array);
        $forms = ReservoirForms::where('year', $year)->orderBy('order_number')->get();
      }
    } else {
      $forms = ReservoirForms::where('year', $year)->orderBy('order_number')->get();
    }

    $object_id = [];
    $objects = GvkObject::where('unit_id', 2)->where('type_id', 1)->get();
    foreach ($objects as $object) {
      $is_yes = false;
      foreach ($forms as $value) {
        if ($object->id == $value->stat_object_id) $is_yes = true;
      }
      if ($is_yes == false) $object_id[] = $object->id;
    }
    $existObject = GvkObject::whereIn('id', $object_id)->where('unit_id', 2)->get();

    $allForms = NewFormsModel::get();
    $unitsList = Unit::get();

    return view('general.data-exchange.reservoir_form', compact(
      'year',
      'existObject',
      'forms',
      'form_id',
      'allForms',
      'unitsList',
      'elements',
      'month'
    ));
  }

  public function AddObjectRes(Request $request)
  {
    if ($request->is_new_object != 1) {
      if ($request->new_object != null || $request->new_object != '') {
        if ($request->in_from == 'reservoir') {
          $newForm = new ReservoirForms();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->gvk_object_id = $request->new_object;
          $newForm->save();
        }

        if ($request->in_from == 'amu') {
          $newForm = new OperAmuForm();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->gvk_object_id = $request->new_object;
          $newForm->save();
        }

        if ($request->in_from == 'sird') {
          $newForm = new OperSirdForm();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->gvk_object_id = $request->new_object;
          $newForm->save();
        }

        if ($request->in_from == 'daily') {
          $newForm = new DailyForm();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->morning = 0;
          $newForm->present = 1;
          $newForm->gvk_object_id = $request->new_object;
          $newForm->save();
        }
      }
    } else {
      if ($request->name != null || $request->name != '') {
        $obj = new GvkObject();
        $obj->number = DB::table('gvk_objects')->max('number') + 1;
        $obj->name = $request->name;
        $obj->form_id = $request->allForms;
        $obj->unit_id = $request->unitsList;
        $obj->type_id = $request->type_id;
        $obj->obj_id = DB::table('gvk_objects')->max('obj_id') + 1;
        $obj->name_ru = $request->name_ru;
        $obj->save();

        if ($request->in_from == 'reservoir') {
          $newForm = new ReservoirForms();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->gvk_object_id = $obj->id;
          $newForm->save();
        }

        if ($request->in_from == 'amu') {
          $newForm = new OperAmuForm();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->gvk_object_id = $obj->id;
          $newForm->save();
        }

        if ($request->in_from == 'sird') {
          $newForm = new OperSirdForm();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->gvk_object_id = $obj->id;
          $newForm->save();
        }

        if ($request->in_from == 'daily') {
          $newForm = new DailyForm();
          $newForm->year = $request->year;
          $newForm->order_number = 1;
          $newForm->check = 1;
          $newForm->morning = 0;
          $newForm->present = 1;
          $newForm->gvk_object_id = $obj->id;
          $newForm->save();
        }
      }
    }
    return back();
  }

  public function DailyForm(Request $request)
  {
    $year = $request->year;
    if (!(bool)strtotime($year . '-01-01')) {
      return view('general.data-exchange.error_form', compact(
        'year'
      ));
    }
    $form = DailyForm::where('year', $year)->get()->first();
    $form_id = $request->form;
    $elements = $request->elements;
    $month = $request->month;

    if ($form == null) {
      $form = DailyForm::orderBy('year', 'desc')->get()->first();
      if ($form != null) {
        $forms = DailyForm::where('year', $form->year)->orderBy('order_number')->get();
        $i = 0;
        $array = array();
        foreach ($forms as $value) {
          $i++;
          $new = array(
            'year' => $year,
            'order_number' => $i,
            'morning' => 0,
            'present' => 1,
            'check' => 1,
            'gvk_object_id' => $value->gvk_object_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
          );
          $array[] = $new;
        }
        if (count($array) > 0) DB::table('daily_forms')->insert($array);
        $forms = DailyForm::where('year', $year)->orderBy('order_number')->get();
      }
    } else {
      $forms = DailyForm::where('year', $year)->orderBy('order_number')->get();
    }

    $object_id = [];
    $objects = GvkObject::get();
    foreach ($objects as $object) {
      $is_yes = false;
      foreach ($forms as $value) {
        if ($object->id == $value->stat_object_id) $is_yes = true;
      }
      if ($is_yes == false) $object_id[] = $object->id;
    }
    $existObject = GvkObject::whereIn('id', $object_id)->get();
    $allForms = NewFormsModel::get();
    $unitsList = Unit::get();

    return view('general.data-exchange.daily_form', compact(
      'year',
      'existObject',
      'forms',
      'form_id',
      'allForms',
      'unitsList',
      'elements',
      'month'
    ));
  }

  public function AddValueAjax(Request $request)
  {
    $info = Information::find($request->id);
    if ($request->field == 'present') $info->value = $request->value;
    if ($request->field == 'morning') $info->average = $request->value;
    $info->save();
    return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
  }

  public function AddInfoAjax(Request $request)
  {
    $info = Information::find($request->id);
    $info->value = $request->value;
    $info->save();
    return response()->json(['msg' => 'Information added successfully', 'id' => $request->id, 'val' => $request->value]);
  }

  protected function getInstanceElements(Request $request)
  {
    // dd($request->all());
    if ($request->instance == 'gidromet') {
      return [
        "Operative Amu",
        "Operative Sird",
        "Rejim Gidro"
      ];
    }
    if ($request->instance == 'minvodxoz') {
      return [
        "Every Day Datas",
        "Volume month reservoir"
      ];
    }
    if ($request->instance == 'gidrogeologiya') {
      return [
        "Place birth",
        "Well"
      ];
    } else return [];
  }

  protected function getInstanceElementData(Request $request)
  {
    // dd($request->all());
    $instances = $this->getInstances();
    $selected_date = $request->selected_date;
    $selected_element = $request->selected_element;
    $selected_instance = $request->selected_instance;

    $r_year = date('Y', strtotime($selected_date));
    $r_month = date('n', strtotime($selected_date));
    $r_days_in_month = date('t', strtotime($selected_date)); // shu oyda necha kun borligi

    // 1) Оператив Амударё
    if ($selected_element == "Operative Amu") {

      $response = Curl::to(config('app.gidrometApiReport1'))
        ->withData([
          'api_token' => config('app.gidrometApiKey'),
          'month' => $selected_date,
        ])
        ->post();
      $response = json_decode($response, true);
      // dd($response);

      if ($response && $response['success']) {

        Information::setOperAmuDatas($response['data'], $r_year, $r_month);
        $formObjects = $response['data']['formObjects'];
        $objectId = [];
        foreach ($formObjects as $object) {
          $objectId[] = $object['gvk_object_id'];
        }

        $allDatas = Information::whereIn('gvk_object_id', $objectId)
          ->whereYear('date', $r_year)
          ->whereMonth('date', $r_month)
          ->orderByRaw("updated_at DESC, date ASC")
          ->get();

        $result = [];

        foreach ($allDatas as $infor) {
          $key = $infor->gvk_object_id . '_' . date('d_m_Y', strtotime($infor->date));
          $result[$key] = $infor->average;
          $result[$key . '_sr'] = $infor->value;
          $result[$key . '_id'] = $infor->id;
        }

        return view('general.data-exchange.amu', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'result',
          'formObjects',
          'r_month',
          'r_year',
          'r_days_in_month'
        ));
      }
    }

    // 2) Оператив Сирдарё
    if ($selected_element == "Operative Sird") {

      $response = Curl::to(config('app.gidrometApiReport2'))
        ->withData([
          'api_token' => config('app.gidrometApiKey'),
          'month' => $selected_date,
        ])
        ->post();
      $response = json_decode($response, true);

      if ($response && $response['success']) {

        Information::setOperSirdDatas($response['data'], $r_year, $r_month);
        //$selected_element = 2;
        $formObjects = $response['data']['formObjects'];
        $objectId = [];
        foreach ($formObjects as $object) {
          $objectId[] = $object['gvk_object_id'];
        }

        $allDatas = Information::whereIn('gvk_object_id', $objectId)
          ->whereYear('date', $r_year)
          ->whereMonth('date', $r_month)
          ->orderByRaw("updated_at DESC, date ASC")
          ->get();

        $result = [];

        foreach ($allDatas as $infor) {
          $key = $infor->gvk_object_id . '_' . date('d_m_Y', strtotime($infor->date));
          $result[$key] = $infor->average;
          $result[$key . '_sr'] = $infor->value;
          $result[$key . '_id'] = $infor->id;
        }

        return view('general.data-exchange.sird-oper', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'result',
          'formObjects',
          'r_month',
          'r_year',
          'r_days_in_month'
        ));
      }
    }

    // 3) Режим гидропоста
    if ($selected_element == "Rejim Gidro") {
      $response = Curl::to(config('app.gidrometApiReport3'))
        ->withData([
          'api_token' => config('app.gidrometApiKey'),
          'year' => $selected_date,
        ])
        ->post();
      $response = json_decode($response, true);
      //dd($response);

      if ($response['success']) {
        RejimGidropost::setDatas($response['data'], $selected_date);
        $allDatas = $response['data'];

        // dd($selected_element);

        return view('general.data-exchange.gidro', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
        ));
      }
    }

    // 4) Ежедневные
    if ($selected_element == "Every Day Datas") {

      $response = Curl::to(config('app.minvodxozApiReport4'))
        ->withData([
          'api_token' => config('app.minvodxozApiKey'),
          'month' => $selected_date,
        ])
        ->post();
      $response = json_decode($response, true);

      if ($response['success']) {

        Information::setDatas($response['data'], $r_year, $r_month);
        $allDatas = $response['data'];
        $day = date('d_m_Y', strtotime($selected_date . '-01'));
        if (!empty($allDatas)) {
          $firstData = $allDatas[$day];
        }
        // dd($firstData);

        return view('general.data-exchange.daily', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'r_month',
          'r_year',
          'allDatas',
          'firstData'
        ));
      }
    }

    // 5) Объемы в/х месячные
    if ($selected_element == "Volume month reservoir") {

      $response = Curl::to(config('app.minvodxozApiReport5'))
        ->withData([
          'api_token' => config('app.minvodxozApiKey'),
          'year' => $r_year,
        ])
        ->post();
      $response = json_decode($response, true);

      if ($response['success']) {

        ReservoirMonthlyDatas::setDatas($response['data'], $r_year);
        $allDatas = $response['data'];

        return view('general.data-exchange.reservoir', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'r_month',
          'r_year'
        ));
      }
    }

    // 6) Место рождение
    if ($selected_element == "Place birth") {

      $response = Curl::to(config('app.gidrogeologiyaApiReport6'))
        ->withData([
          'api_token' => config('app.gidrogeologiyaApiKey'),
          'year' => $r_year,
        ])
        ->post();
      // dd($response);
      $response = json_decode($response, true);

      if ($response && $response['success']) {
        GidrogeologiyaPlaceBirth::setDatas($response['data'], $r_year);
        $allDatas = $response['data'];

        return view('general.data-exchange.place-birth', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'r_month',
          'r_year'
        ));
      }
    }

    // 7) Скважина
    if ($selected_element == "Well") {

      $response = Curl::to(config('app.gidrogeologiyaApiReport7'))
        ->withData([
          'api_token' => config('app.gidrogeologiyaApiKey'),
          'year' => $r_year,
        ])
        ->post();
      $response = json_decode($response, true);

      if ($response && $response['success']) {
        GidrogeologiyaWellData::setDatas($response['data'], $r_year);
        $allDatas = $response['data'];

        return view('general.data-exchange.well-data', compact(
          'instances',
          'selected_instance',
          'selected_element',
          'selected_date',
          'allDatas',
          'r_month',
          'r_year'
        ));
      }
    }

    return back()->with('warning', 'Not Found!');
  }

  private function getInstances()
  {
    return [
      'gidromet',
      'minvodxoz',
      'gidrogeologiya'
    ];
  }
}
