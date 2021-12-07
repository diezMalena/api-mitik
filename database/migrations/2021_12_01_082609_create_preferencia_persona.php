<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferenciaPersona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferencias_personas', function (Blueprint $table) {
            $table->string('correo');
            $table->unsignedBigInteger('id_preferencia');
            $table->integer('intensidad');
            $table->primary(['correo', 'id_preferencia']);

            $table->foreign('correo')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_preferencia')->references('id')->on('preferencias');
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
        Schema::dropIfExists('preferencia_persona');
    }
}
