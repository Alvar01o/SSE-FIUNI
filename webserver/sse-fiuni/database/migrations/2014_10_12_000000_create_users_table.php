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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->integer('ci')->nullable();
            $table->string('email')->unique();
            $table->integer('ingreso')->length(4)->default(0);
            $table->integer('egreso')->length(4)->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('carrera_id')->default(0);
            $table->string('password');
            $table->string('token_invitacion')->nullable();
            $table->boolean('confirmado')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
