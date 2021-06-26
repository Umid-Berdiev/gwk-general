<?php

use App\Models\Additional\Language;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

function getMonthName($month)
{
  if ($month == 1) return 'january';
  else if ($month == 2) return 'february';
  else if ($month == 3) return 'march';
  else if ($month == 4) return 'april';
  else if ($month == 5) return 'may';
  else if ($month == 6) return 'june';
  else if ($month == 7) return 'july';
  else if ($month == 8) return 'august';
  else if ($month == 9) return 'september';
  else if ($month == 10) return 'october-';
  else if ($month == 11) return 'november';
  else if ($month == 12) return 'decamber';
}

function makeLangFiles()
{
  $langs = Language::query()->get();
  // dd($langs);
  $path = base_path("resources/lang/");
  foreach ($langs as $el) {
    $words = DB::table('metkis')->where('language_id', $el->id)->get();
    // $words = Term::where('language_id', $el->id)->get();
    $text = "<?php\n\treturn [";
    foreach ($words as $word) {
      $text .= "\n\t\t\"" . $word->id_column . "\" => \"" . $word->mark_name . "\",";
    }
    $text .= "\n\t];\n?>";
    // dd($text);
    File::makeDirectory($path . $el->language_prefix, 0777, true, true);
    File::put($path . "$el->language_prefix/messages.php", $text);
  }
}

function modifyValuePHP($value, $parameter)
{
  $tempValue = 0;

  if ($value == -666)
    if ($parameter->param_name == 'Уровень воды') return "прсх";
    else return "нб";
  if ($value == -777)
    return "прмз";
  if ($value == -888)
    return "-";
  if ($value >= 100)
    $tempValue = round($value);
  if ($value >= 10 && $value < 100)
    $tempValue = round($value, 1);
  if ($value >= 1 && $value < 10)
    $tempValue = round($value, 2);
  if ($value < 1 && $value >= 0)
    $tempValue = round($value, 3);

  return $tempValue;
}

function getMonths()
{
  return [
    "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII",
  ];
}

function getUserResourceTypes()
{
  $user_resource_types = [];

  if (auth()->user()->org_name == 'other') {
    $user_resource_types = [
      ['value' => 1, 'name' => 'General Resource table 1'],
      ['value' => 2, 'name' => 'General Resource table 2'],
      ['value' => 3, 'name' => 'General Resource table 3'],
      ['value' => 4, 'name' => 'General Resource table 4'],
      ['value' => 5, 'name' => 'General Resource table 5'],
      ['value' => 6, 'name' => 'General Resource table 6'],
      ['value' => 7, 'name' => 'General Resource table 6_a'],
      ['value' => 8, 'name' => 'General Resource table 6_b'],
      ['value' => 9, 'name' => 'General Resource table 7'],
      ['value' => 10, 'name' => 'General Resource table 9']
    ];
  }

  if (auth()->user()->org_name == 'gidromet') {
    $user_resource_types = [
      ['value' => 1, 'name' => 'General Resource table 1'],
      ['value' => 3, 'name' => 'General Resource table 3'],
      ['value' => 4, 'name' => 'General Resource table 4'],
      ['value' => 8, 'name' => 'General Resource table 6_b'],
      ['value' => 9, 'name' => 'General Resource table 7'],
      ['value' => 10, 'name' => 'General Resource table 9']
    ];
  }

  if (auth()->user()->org_name == 'gidrogeologiya') {
    $user_resource_types = [
      ['value' => 2, 'name' => 'General Resource table 2'],
      ['value' => 5, 'name' => 'General Resource table 5'],
    ];
  }

  if (auth()->user()->org_name == 'minvodxoz') {
    $user_resource_types = [
      ['value' => 6, 'name' => 'General Resource table 6'],
      ['value' => 7, 'name' => 'General Resource table 6_a'],
    ];
  }

  return $user_resource_types;
}

function getRegionNames()
{
  return [
    "Республика Каракалпакистан",
    "Андижанский",
    "Бухарский",
    "Джизакский",
    "Кашкадарьинский",
    "Навоиский",
    "Наманганский",
    "Самаркандский",
    "Сурхандарьинский",
    "Сырдарьинский",
    "Ташкентский",
    "Ферганский",
    "Хорезмский",
    "Республика Узбекистан"
  ];
}
