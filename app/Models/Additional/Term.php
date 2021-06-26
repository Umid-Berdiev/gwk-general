<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
  protected $guarded = [];
  protected $table = 'metkis';

  public function language()
  {
    return $this->belongsTo(Language::class, 'group_id');
  }
}
