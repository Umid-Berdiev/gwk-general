<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectHistory extends Model
{
    use HasFactory;
    protected $table = 'object_history';
    protected $fillable = [
      'id',
      'name',
      'form_id',
      'unit_id',
      'type_id',
      'get',
      'set',
      'obj_id',
      'name_ru',
    ];
}
