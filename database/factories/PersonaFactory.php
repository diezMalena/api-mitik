<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Persona;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;
    public static $correoAux;
    public function definition()
    {
        $fak = \Faker\Factory::create('es_ES');
        self::$correoAux =  $fak->email;
        return ['correo' => self::$correoAux,
        'nombre' => $this->faker->name,
        'contraseña' => 'gatito',
        'fechaNacimiento' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        'ciudad' => $this->faker->state,
        'descripcion' => $this->faker->randomElement(['mu wape', 'me gusta doraemon', 'el amor de tu vida']),
        'tipoRelacion' => $this->faker->randomElement(['esporadica', 'seria', 'lo k surja']),
        'foto' => '/images/prueba/'.rand(1,32).'.jpg',
        'tieneHijos' => rand(0,1),
        'quiereHijos' => rand(0,1),
        'conectado' => rand(0,1),
        'activado' => rand(0,1),
        'tema' => rand(0,1),
        'id_genero' => rand(1,3)  //H M NB
        ];
    }
}
