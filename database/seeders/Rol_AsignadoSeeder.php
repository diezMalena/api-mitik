<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Persona;
use App\Models\Rol_Asignado;

class Rol_AsignadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol_Asignado::create(['descripcion'=>'Administrador']);
        Rol_Asignado::create(['descripcion'=>'Usuario']);
    }
}
