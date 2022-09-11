<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OpcionesPregunta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opciones_preguntas', function (Blueprint $table) {
            $table->id();
            $table->integer('pregunta_id');
            $table->integer('encuesta_id');
            $table->string('opcion');
            $table->timestamps();
        });

        DB::unprepared('
            CREATE TRIGGER `preguntas_ad` AFTER DELETE ON `preguntas` FOR EACH ROW
            BEGIN
                delete from opciones_preguntas where pregunta_id = OLD.id;
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
        Schema::dropIfExists('opciones_preguntas');
        DB::unprepared('DROP TRIGGER `preguntas_ad`');

    }
}
