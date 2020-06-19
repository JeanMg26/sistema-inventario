<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreareSupervisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisiones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bienes_enc')->nullable();
            $table->integer('bienes_adic')->nullable();
            $table->string('observacion')->nullable();
            $table->date('fecha');
            $table->integer('user_ing');

            $table->unsignedBigInteger('equipos_id');
            $table->foreign('equipos_id', 'fk_supervisiones_equipos')->references('id')->on('equipos')->onDelete('restrict')->onUpdate('restrict');

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
        Schema::dropIfExists('supervisiones');
    }
}
