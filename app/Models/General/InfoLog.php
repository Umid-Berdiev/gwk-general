<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoLog extends Model
{
    const TYPE_AMU = 1;
    const TYPE_SIR = 2;
    const TYPE_REJIM_GIDRO = 3;
    const TYPE_MIN_DAILY = 4;
    const TYPE_MIN_RECO = 5;
    const TYPE_GIDROFEOLOGIYA_RECO = 6;
    const TYPE_GIDROFEOLOGIYA_WELL = 7;

    use HasFactory;

    protected $table = 'info_log';
    protected $fillable = [
        'id',
        'type',
    ];

  /**
   * @param $type
   */
    public static function addLog($type){
      $log = new InfoLog();
      $log->type = $type;
      $log->save();
    }

}
