<?php

namespace App\Models\General;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ResourcesRegions extends Model
{
  public function users()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
