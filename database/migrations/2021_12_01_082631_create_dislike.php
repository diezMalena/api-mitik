<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDislike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dislikes', function (Blueprint $table) {
            $table->string('correo1');
            $table->string('correo2');
            $table->primary(['correo1','correo2']);
            $table->timestamps();

            $table->foreign('correo1')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('correo2')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dislike');
    }
}
