<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->string('correo')->primary();
            $table->string('nombre');
            $table->string('contraseña');
            $table->date('fechaNacimiento');
            $table->string('ciudad');
            $table->string('descripcion');
            $table->string('tipoRelacion');
            $table->string('foto');
            $table->integer('tieneHijos');
            $table->integer('quiereHijos');
            $table->integer('conectado');
            $table->integer('activado');
            $table->integer('tema');
            $table->unsignedBigInteger('id_genero');
            $table->timestamps();

            $table->foreign('id_genero')->references('id')->on('generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
