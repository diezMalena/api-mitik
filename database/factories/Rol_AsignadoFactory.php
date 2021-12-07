<?php

namespace Database\Factories;

use App\Models\Rol_Asignado;
use Illuminate\Database\Eloquent\Factories\Factory;

class Rol_AsignadoFactory extends Factory
{
    protected $model = Rol_Asignado::class;
    public static $correo;

    public function definition()
    {
        return [
            'correo'=>self::$correo,
            'id_rol'=>2
        ];
    }
}
