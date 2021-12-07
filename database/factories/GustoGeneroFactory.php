<?php

namespace Database\Factories;

use App\Models\GustoGenero;
use Illuminate\Database\Eloquent\Factories\Factory;

class GustoGeneroFactory extends Factory
{
    protected $model = GustoGenero::class;
    public static $correo;
    public static $id_genero;

    public function definition()
    {
        return [
            'correo'=>self::$correo,
            'id_genero'=>self::$id_genero
        ];
    }
}
