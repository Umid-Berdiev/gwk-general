<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;

class UzRegion extends Model
{
  public function waterbodies()
  {
    return $this->hasOne(Waterbodies_attr::class, 'region_id', 'regionid');
  }
}
