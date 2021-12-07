<?php

namespace App\Http\Controllers;
use App\Models\Genero;
use App\Models\Preferencia;
use Illuminate\Http\Request;

class controladorGeneral extends Controller
{
    public function listarGeneros(){
        return Genero::all();
    }

    public function listarPreferencias(){
        return Preferencia::all();
    }
}
