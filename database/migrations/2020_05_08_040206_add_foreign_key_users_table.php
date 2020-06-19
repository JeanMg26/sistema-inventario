<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyUsersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('users', function (Blueprint $table) {
         $table->unsignedBigInteger('empleados_id')->nullable();
         $table->foreign('empleados_id', 'fk_users_empleados')->references('id')->on('empleados')->onDelete('restrict')->onUpdate('restrict');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('users', function (Blueprint $table) {
         $table->dropForeign('empleados_id');
      });
   }
}
