<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
   use SoftDeletes;

   protected $table   = 'areas';
   protected $dates   = ['deleted_at'];
   protected $guarded = ['id'];
}
