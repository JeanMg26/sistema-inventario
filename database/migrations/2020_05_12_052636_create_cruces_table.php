<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrucesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cruces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bienes_id');
            $table->foreign('bienes_id', 'fk_cruces_bienes')->references('id')->on('bienes')->onDelete('restrict')->onUpdate('restrict');

            $table->unsignedBigInteger('equipos_id')->nullable();
            $table->foreign('equipos_id', 'fk_cruces_equipos')->references('id')->on('equipos')->onDelete('restrict')->onUpdate('restrict');
            // Ubicaciones de la BD
            $table->unsignedBigInteger('locales_db');
            $table->foreign('locales_db', 'fk_cruces_localesDB')->references('id')->on('locales')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('areas_db');
            $table->foreign('areas_db', 'fk_cruces_areasDB')->references('id')->on('areas')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('oficinas_db');
            $table->foreign('oficinas_db', 'fk_cruces_oficinasDB')->references('id')->on('oficinas')->onDelete('restrict')->onUpdate('restrict');

            // Ubicaciones Fisicas
            $table->unsignedBigInteger('locales_enc');
            $table->foreign('locales_enc', 'fk_cruces_localesENC')->references('id')->on('locales')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('areas_enc');
            $table->foreign('areas_enc', 'fk_cruces_areasENC')->references('id')->on('areas')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('oficinas_enc');
            $table->foreign('oficinas_enc', 'fk_cruces_oficinasENC')->references('id')->on('oficinas')->onDelete('restrict')->onUpdate('restrict');

            $table->string('observacion')->nullable();
            $table->boolean('estado');
            $table->integer('user_ing');

            $table->softDeletes();
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
        Schema::dropIfExists('cruces');
    }
}
