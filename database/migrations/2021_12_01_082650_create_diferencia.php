<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiferencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diferencias', function (Blueprint $table) {
            $table->string('correo1');
            $table->string('correo2');
            $table->integer('diferencia'); //este numero será el resultado de calcular la afinidad
            //entre dos personas, que luego se comparará con diferentes rangos para saber si eres mas o menos afin.
            $table->primary(['correo1','correo2']);

            $table->foreign('correo1')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('correo2')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('diferencia');
    }
}
