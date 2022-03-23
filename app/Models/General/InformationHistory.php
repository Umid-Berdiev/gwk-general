<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationHistory extends Model
{
  use HasFactory;

  protected $table = 'information_history';
  protected $fillable = [
    'id',
    'date',
    'value',
    'average',
    'form_id',
    'gvk_object_id',
    'type',
  ];

  /**
   * @param $data
   */
  public static function setHistory($formObjects, $result, $year, $type)
  {
    AmuSirForms::whereNotIn('gvk_object_id', array_column($formObjects, 'gvk_object_id'))->delete();
    foreach ($formObjects as $value) {
      AmuSirForms::updateOrCreate([
        'gvk_object_id' => $value['gvk_object_id'],
        'year'          => $value['year'],
        'type'          => $type,
      ],
        [
          'gvk_object_id' => $value['gvk_object_id'],
          'order_number' => $value['order_number'],
          'check' => $value['check'],
          'year' => $value['year'],
          'type' => $type,
        ]
      );

      if (isset($value['object']) && $value['object']) {
        $data = $value['object'];

        $model = ObjectHistory::updateOrCreate([
          'id' => $data['id'] ?? '',
        ], [
          'id'    => $data['id'] ?? null,
          'name'  => $data['name'] ?? null,
          'form_id' => $data['form_id'] ?? null,
          'unit_id' => $data['unit_id'] ?? null,
          'type_id' => $data['type_id'] ?? null,
          'get'   => $data['get'] ?? null,
          'set'   => $data['set'] ?? null,
          'obj_id'  => $data['obj_id'] ?? null,
          'name_ru' => $data['name_ru'] ?? null,
        ]);
      }
    }

    foreach ($result as $value) {
      InformationHistory::updateOrCreate([
        'date' => $value['date'],
        'gvk_object_id' => $value['gvk_object_id'],
        'type' => $type,
      ], [
        'date' => $value['date'],
        'value' => $value['value'],
        'average' => $value['average'],
        'form_id' => $value['form_id'],
        'gvk_object_id' => $value['gvk_object_id'],
        'type' => $type,
      ]);
    }
    return true;
  }
}
