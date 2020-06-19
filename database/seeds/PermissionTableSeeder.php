<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      
      $permissions = [
         'ROL-LISTAR',
         'ROL-CREAR',
         'ROL-EDITAR',
         'ROL-ELIMINAR',
         'USUARIO-LISTAR',
         'USUARIO-CREAR',
         'USUARIO-EDITAR',
         'USUARIO-ELIMINAR',
      ];

      foreach ($permissions as $permission) {
         Permission::create(['name' => $permission, 'status' => '1', 'module' => 'permiso']);
      }
   }

}
