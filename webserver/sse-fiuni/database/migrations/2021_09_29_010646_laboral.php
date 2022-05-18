<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Laboral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboral', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->string('cargo');
            $table->dateTime('inicio');
            $table->dateTime('fin')->nullable();
            $table->integer('user_id');
            $table->integer('empleador_id')->nullable();
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
        Schema::dropIfExists('laboral');
    }
}
