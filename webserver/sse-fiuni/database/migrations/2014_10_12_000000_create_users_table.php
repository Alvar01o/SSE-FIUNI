<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
                Schema::create('users', function (Blueprint $table) {
                    $table->id();
                    $table->string('nombre');
                    $table->string('apellido');
                    $table->string('genero')->nullable();
                    $table->integer('ci')->nullable();
                    $table->string('email')->unique();
                    $table->integer('ingreso')->length(4)->default(0);
                    $table->integer('egreso')->length(4)->default(0);
                    $table->timestamp('email_verified_at')->nullable();
                    $table->integer('carrera_id')->default(0);
                    $table->string('password');
                    $table->string('token_invitacion')->nullable();
                    $table->boolean('notificado')->default(false);
                    $table->boolean('confirmado')->default(false);
                    $table->rememberToken();
                    $table->timestamps();
                });

                DB::unprepared('
                    CREATE TRIGGER `users_ad` AFTER DELETE ON `users` FOR EACH ROW
                    BEGIN
                        delete from laboral_user where user_id = OLD.id;
                        delete from educacion where user_id = OLD.id;
                        delete from encuesta_users where user_id = OLD.id;
                        delete from respuesta_preguntas where egresado_id = OLD.id;
                        delete from model_has_roles where model_id = OLD.id;
                        delete from media where model_id = OLD.id;
                        delete from datos_personales where user_id = OLD.id;
                    END
                ');
        }
    }

    /**
     * Reverse the migrations.
    *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        DB::unprepared('DROP TRIGGER IF EXISTS `preguntas_ad`');
    }
}
