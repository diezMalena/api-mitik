<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensaje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('correoOrigen');
            $table->string('correoDestino');
            $table->string('texto');
            $table->integer('leido');

            $table->foreign('correoOrigen')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('correoDestino')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('mensaje');
    }
}
