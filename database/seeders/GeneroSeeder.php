<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genero;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genero::create(['descripcion'=>'Hombre']);
        Genero::create(['descripcion'=>'Mujer']);
        Genero::create(['descripcion'=>'No binario']);
    }
}
