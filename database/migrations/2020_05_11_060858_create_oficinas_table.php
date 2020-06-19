<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOficinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oficinas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codoficina', 20);
            $table->string('descripcion', 100);
            $table->boolean('estado');
            $table->unsignedBigInteger('locales_id');
            $table->foreign('locales_id', 'fk_oficinas_locales')->references('id')->on('locales')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('areas_id');
            $table->foreign('areas_id', 'fk_oficinas_areas')->references('id')->on('areas')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('oficinas');
    }
}
