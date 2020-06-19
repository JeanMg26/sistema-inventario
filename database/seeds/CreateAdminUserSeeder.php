<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $user = User::create([
         'name'     => 'Giancarlo Montalvan',
         'email'    => 'jeanmg25@gmail.com',
         'password' => bcrypt('123456'),
         'status'    => '1',
      ]);

      $role = Role::create(['name' => 'ADMINISTRADOR', 'status' => '1']);

      $permissions = Permission::pluck('id', 'id')->all();

      $role->syncPermissions($permissions);

      $user->assignRole([$role->id]);
   }
}
