<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Preferencia;

class PreferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preferencia::create(['descripcion'=>'Arte']);
        Preferencia::create(['descripcion'=>'Musica']);
        Preferencia::create(['descripcion'=>'Política']);
        Preferencia::create(['descripcion'=>'Deporte']);
    }
}
