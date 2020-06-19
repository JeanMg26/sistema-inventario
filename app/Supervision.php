<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supervision extends Model
{
   use SoftDeletes;

   protected $table   = 'supervisiones';
   protected $dates   = ['deleted_at'];
   protected $guarded = ['id', 'user_ing'];
}
