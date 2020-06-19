<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{

   protected $table   = 'bienes';
   protected $fillable = ['codbien', 'descripcion', 'codlocal', 'local', 'codarea', 'area', 'codoficina', 'oficina', 'pabellon', 'codusuario', 'usuario', 'estado', 'marca', 'modelo', 'dimension', 'color', 'serie', 'fec_reg', 'sit_bien', 'dsc_otros', 'obs_interna', 'cod_completo'];
   protected $guarded = ['id'];

   protected $hidden = ['created_at', 'updated_at'];
}
