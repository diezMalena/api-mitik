<?php

namespace Database\Factories;

use App\Models\PreferenciaPersona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreferenciaPersonaFactory extends Factory
{
    protected $model = PreferenciaPersona::class;
    public static $correo;
    public static $id_prefe;

    public function definition()
    {
        return [
            'correo'=>self::$correo,
            'id_preferencia'=>self::$id_prefe,
            'intensidad'=>rand(0,100)
        ];
    }
}
