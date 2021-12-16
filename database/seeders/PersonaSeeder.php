<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Persona;
use Database\Factories\PersonaFactory;
use App\Models\Rol_Asignado;
use Database\Factories\Rol_AsignadoFactory;
use App\Models\GustoGenero;
use App\Models\Preferencia;
use App\Models\PreferenciaPersona;
use Database\Factories\GustoGeneroFactory;
use Database\Factories\PreferenciaPersonaFactory;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 2; $i++){
            $persona = Persona::factory()->create();
            //dd(PersonaFactory::$correoAux);
            //Le asignamos el rol a la persona:
            Rol_AsignadoFactory::$correo = PersonaFactory::$correoAux;
            Rol_Asignado::factory()->create();

            //Le asignamos las preferencias a la persona:
            for ($j = 0; $j < Preferencia::all()->count() ; $j++) {
                PreferenciaPersonaFactory::$correo = PersonaFactory::$correoAux;
                PreferenciaPersonaFactory::$id_prefe = $j;
                PreferenciaPersona::factory()->create();
            }

            //Le asignamos los gustos a la persona:
            GustoGeneroFactory::$correo = PersonaFactory::$correoAux;
            if($i % 3 == 0 || $i % 2 == 0){
                GustoGeneroFactory::$id_genero = 1;
                GustoGenero::factory()->create();
            }
            if($i % 3 == 1 || $i % 2 != 0){
                GustoGeneroFactory::$id_genero = 2;
                GustoGenero::factory()->create();
            }
            if($i % 3 == 2){
                GustoGeneroFactory::$id_genero = 3;
                GustoGenero::factory()->create();
            }
        }
    }
}
