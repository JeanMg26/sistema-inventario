<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Local extends Model
{
   use SoftDeletes;

   protected $table   = 'locales';
   protected $dates   = ['deleted_at'];
   protected $guarded = ['id'];
}
