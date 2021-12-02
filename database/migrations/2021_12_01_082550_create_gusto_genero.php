<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGustoGenero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gusto_generos', function (Blueprint $table) {
            $table->string('correo');
            $table->unsignedBigInteger('id_genero');
            $table->primary(['correo', 'id_genero']);

            $table->foreign('correo')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_genero')->references('id')->on('generos');
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
        Schema::dropIfExists('gusto_genero');
    }
}
