<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Preguntas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta');
            $table->boolean('requerido')->default(false);
            $table->boolean('justificacion')->nullable();
            $table->integer('encuesta_id');
            $table->enum('tipo_pregunta', ['pregunta', 'seleccion_multiple', 'seleccion_multiple_justificacion', 'seleccion', 'seleccion_justificacion']);
            $table->timestamps();
        });
        DB::unprepared('
            CREATE TRIGGER `encuestas_ad` AFTER DELETE ON `encuestas` FOR EACH ROW
            BEGIN
                delete from preguntas where encuesta_id = OLD.id;
                delete from encuesta_users where encuesta_id = OLD.id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas');
        //DB::unprepared('DROP TRIGGER `encuestas_ad`');
    }
}
