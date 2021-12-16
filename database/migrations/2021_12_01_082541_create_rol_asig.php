<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolAsig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_asignados', function (Blueprint $table) {
            $table->string('correo');
            $table->unsignedBigInteger('id_rol');
            $table->primary(['correo', 'id_rol']);
            $table->timestamps();
            $table->foreign('correo')->references('correo')->on('personas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol_asig');
    }
}
