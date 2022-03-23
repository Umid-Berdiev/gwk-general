<?php

namespace App\Models\Gidrogeologiya;

use Illuminate\Database\Eloquent\Model;

class GidrogeologiyaPlaceBirth extends Model
{
  protected $table = 'gidrogeologiya_place_birth';
  public $timestamps = false;

  protected $fillable = [
    'code', 'name', 'year', 'groundwater_resource', 'selection_from_approved_groundwater_reserves', 'favcolor'
  ];

  public static function setDatas($datas, $year)
  {
    $oldDatas = GidrogeologiyaPlaceBirth::where('year', $year)->get();
    foreach ($datas as $data) {
      //dd($data);
      $model = $oldDatas->filter(function ($item) use ($year, $data) {
        return $item->year == $year &&
          $item->code == $data['properties']['code'] &&
          $item->name == $data['properties']['name'];
      })->first();

      if ($model == null) $model = new GidrogeologiyaPlaceBirth();

      $model->code = $data['properties']['code'];
      $model->name = $data['properties']['name'];
      $model->year = $year;
      $model->groundwater_resource = (float)$data['properties']['groundwater_resource'];
      $model->selection_from_approved_groundwater_reserves = (float)$data['properties']['selection_from_approved_groundwater_reserves'];
      $model->favcolor = $data['properties']['favcolor'];
      $model->save();
    }
    return true;
  }

}
