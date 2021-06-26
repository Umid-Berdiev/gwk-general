<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'guard_name',
    ];
}
