<?php

namespace App\Models\Gidromet;

use Illuminate\Database\Eloquent\Model;

class RejimGidropost extends Model
{
    protected $table = 'rejim_gidropost';
    public $timestamps = false;
    protected $fillable = [
        'station_id',
        'year',
        'parameter_id',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'decamber',
    ];

  public function station()
  {
    return $this->belongsTo(Station::class);
  }

  public function parameter()
  {
    return $this->belongsTo(GidrometParameter::class);
  }

  /*
   * ***************** parametrni topib olish ********************
   */
  public static function findGidrometParameter($data)
  {
    if (isset($data['parameter']['param_id']) && isset($data['parameter']['param_name'])) {

      $param = GidrometParameter::where('param_id', $data['parameter']['param_id'])
        ->where('param_name', $data['parameter']['param_name'])
        ->first();

      if (empty($param)) {

        $prNew = new GidrometParameter();
        $prNew->param_id = $data['parameter']['param_id'];
        $prNew->param_name = $data['parameter']['param_name'];
        $prNew->save();
        return $prNew->id ?? null;

      }
      return $param->id ?? null;
    }
    return null;
  }


  /**
   * @param $data
   * @return mixed|null
   * stattion
   */
  public static function findStation($data)
  {
    if (isset($data['station']['station_code']) && isset($data['station']['station_name']) && isset($data['station']['station_id'])) {

      $station = Station::where('station_code', $data['station']['station_code'])
        ->where('station_name', $data['station']['station_name'])
        ->where('station_id', $data['station']['station_id'])
        ->first();

      if (empty($station)) {

        $newStation = new Station();
        $newStation->station_code = $data['station']['station_code'];
        $newStation->order_number = $data['station']['order_number'];
        $newStation->waterbodytype_id = $data['station']['waterbodytype_id'];
        $newStation->station_name = $data['station']['station_name'];
        $newStation->station_id = $data['station']['station_id'];
        $newStation->ugm = $data['station']['ugm'];
        $newStation->pool_squire = $data['station']['pool_squire'];
        $newStation->height_system = $data['station']['height_system'];
        $newStation->source_distance = $data['station']['source_distance'];
        $newStation->location = $data['station']['location'];
        $newStation->cadastre_id = $data['station']['cadastre_id'];
        $newStation->river_name = $data['station']['river_name'];
        $newStation->latitude = $data['station']['latitude'];
        $newStation->longitude = $data['station']['longitude'];
        $newStation->station_zero_height = $data['station']['station_zero_height'];
        $newStation->save();
        return $newStation->id ?? null;

      }
      return $station->id ?? null;
    }
    return null;
  }


  /**
   * @param $datas
   * @param $year
   */
  public static function setDatas($datas, $year)
  {
    foreach ($datas as $data) {
        $parameter_id = self::findGidrometParameter($data);
        $station_id = self::findStation($data);
        $average = $data['gidromet_average'];

        $model = RejimGidropost::where('year',(int)$year)
          ->where('station_id', $station_id)
          ->where('parameter_id', $parameter_id)
          ->first();

        if (empty($model)){
          $model = new RejimGidropost();
        }
        $model->year = $year;
        $model->station_id = $station_id;
        $model->parameter_id = $parameter_id;
        $model->january = (float)($average['I'] ?? null);
        $model->february = (float)($average['II'] ?? null);
        $model->march = (float)($average['III'] ?? null);
        $model->april = (float)($average['IV'] ?? null);
        $model->may = (float)($average['V'] ?? null);
        $model->june = (float)($average['VI'] ?? null);
        $model->july = (float)($average['VII'] ?? null);
        $model->august = (float)($average['VIII'] ?? null);
        $model->september = (float)($average['IX'] ?? null);
        $model->october = (float)($average['X'] ?? null);
        $model->november = (float)($average['XI'] ?? null);
        $model->decamber = (float)($average['XII'] ?? null);
        $model->save();
      }
    }
}
