<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres', 40);
            $table->string('apellidos', 40);
            $table->string('completos', 100)->nullable();
            $table->string('email', 50)->nullable();
            $table->char('genero', 1);
            $table->string('tipodoc', 50);
            $table->string('nrodoc', 12);
            $table->string('celular', 12)->nullable();
            $table->string('rutaimagen')->nullable();
            $table->boolean('estado');

            $table->unsignedBigInteger('equipos_id');
            $table->foreign('equipos_id', 'fk_empleados_equipos')->references('id')->on('equipos')->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('profesiones_id');
            $table->foreign('profesiones_id', 'fk_empleados_profesiones')->references('id')->on('profesiones')->onDelete('restrict')->onUpdate('restrict');

            $table->softDeletes();
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation  = 'utf8mb4_spanish_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
