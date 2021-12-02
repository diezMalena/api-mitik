<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Persona;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return ['correo' => $this->faker->email,
        'nombre' => $this->faker->name,
        'contraseña' => $this->faker->password,
        'fechaNacimiento' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        'ciudad' => $this->faker->state,
        'descripcion' => $this->faker->randomElement(['mu wape', 'me gusta doraemon', 'el amor de tu vida']),
        'tipoRelacion' => $this->faker->randomElement(['esporadica', 'seria', 'lo k surja']),
        'foto' => $this->faker->randomElement(['selfie', 'retrato', 'no se que poner']),
        'tieneHijos' => rand(0,1),
        'quiereHijos' => rand(0,1),
        'conectado' => rand(0,1),
        'activado' => rand(0,1),
        'tema' => rand(0,1),
        'id_genero' => rand(1,3)  //H M NB
        ];
    }
}
