<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RespuestaPreguntas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuesta_preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('respuesta');
            $table->integer('pregunta_id');
            $table->integer('encuesta_id');
            $table->integer('opcion_id');
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
        Schema::dropIfExists('respuesta_preguntas');
    }
}
