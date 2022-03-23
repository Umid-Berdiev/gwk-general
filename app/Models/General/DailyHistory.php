<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyHistory extends Model
{
    use HasFactory;
    protected $table = 'daily_history';
    protected $fillable = [
        'id',
        'object_id',
        'object_name',
        'formObjectMorning',
        'formObjectPresent',
        'formId',
        'parentId',
        'dateCr',
        'morning',
        'present',
    ];


  /**
   * @param $datas
   * @return bool
   */
    public static function setHistpory($datas)
    {
        foreach ($datas as $value){
            foreach ($value as $val){
                DailyHistory::updateOrCreate([
                    'object_id' => $val['object_id'],
                    'formId' => $val['formId'],
                    'dateCr' => date('Y-m-d' ,strtotime($val['dateCr'] ?? null)),
                ],[
                  'object_id' => $val['object_id'] ?? null,
                  'object_name' => $val['object_name'] ?? null,
                  'formObjectMorning' => $val['formObjectMorning'] ?? null,
                  'formObjectPresent' => $val['formObjectPresent'] ?? null,
                  'formId' => $val['formId'] ?? null,
                  'parentId' => $val['parentId'] ?? null,
                  'dateCr' => date('Y-m-d' ,strtotime($val['dateCr'] ?? null)),
                  'morning' => $val['morning'] ?? null,
                  'present' => $val['present'] ?? null,
                ]);
            }
        }
        return true;
    }
}
