<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coordinacion extends Model
{
    use SoftDeletes;

   protected $table   = 'coordinaciones';
   protected $dates   = ['deleted_at'];
   protected $guarded = ['id', 'user_ing'];
}
