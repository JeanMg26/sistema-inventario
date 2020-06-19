<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hoja_ent');
            $table->integer('sticker_ent');
            $table->date('fec_ent');
            $table->integer('hoja_ret')->nullable();
            $table->integer('sticker_ret')->nullable();
            $table->integer('adic_ret')->nullable();
            $table->date('fec_ret')->nullable();
            $table->integer('bienes_ubi')->nullable();
            $table->integer('bienes_noubi')->nullable();
            $table->integer('bienes_adic')->nullable();
            $table->string('observacion')->nullable();
            $table->string('cod_completo', 30); 
            $table->boolean('estado');
            $table->integer('user_ing');

            $table->unsignedBigInteger('equipos_id');
            $table->foreign('equipos_id', 'fk_coordinaciones_equipos')->references('id')->on('equipos')->onDelete('restrict')->onUpdate('restrict');
            
            $table->unsignedBigInteger('locales_id');
            $table->foreign('locales_id', 'fk_coordinaciones_locales')->references('id')->on('locales')->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('areas_id');
            $table->foreign('areas_id', 'fk_coordinaciones_areas')->references('id')->on('areas')->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('oficinas_id');
            $table->foreign('oficinas_id', 'fk_coordinaciones_oficinas')->references('id')->on('oficinas')->onDelete('restrict')->onUpdate('restrict');

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
        Schema::dropIfExists('coordinaciones');
    }
}
