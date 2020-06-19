<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oficina extends Model
{
   use SoftDeletes;

   protected $table   = 'oficinas';
   protected $dates   = ['deleted_at'];
   protected $guarded = ['id'];
}
