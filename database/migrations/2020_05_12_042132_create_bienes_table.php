<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBienesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codbien', 12);
            $table->string('descripcion', 250);
            $table->string('codlocal', 20);
            $table->string('local', 150);
            $table->string('codarea', 20);
            $table->string('area', 150);
            $table->string('codoficina', 20);
            $table->string('oficina', 150);
            $table->string('pabellon', 100);
            $table->string('codusuario', 6);
            $table->string('usuario', 100);
            $table->string('estado', 2);
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->string('dimension', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('serie', 50)->nullable();
            $table->date('fec_reg');
            $table->string('sit_bien', 2);
            $table->string('dsc_otros')->nullable();
            $table->string('obs_interna')->nullable();
            $table->string('cod_completo', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bienes');
    }
}
