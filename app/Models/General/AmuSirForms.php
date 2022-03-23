<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmuSirForms extends Model
{
    use HasFactory;
    protected $table = 'amu_sir_forms';

    const TYPE_AMU = 1;
    const TYPE_SIR = 2;

    protected $fillable = [
      'id',
      'gvk_object_id',
      'order_number',
      'check',
      'year',
      'type',
    ];

  public function object()
  {
    return $this->hasOne('App\Models\General\ObjectHistory', 'id', 'gvk_object_id');
  }

}
