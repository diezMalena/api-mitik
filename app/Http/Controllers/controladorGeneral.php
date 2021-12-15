<?php

namespace App\Http\Controllers;
use App\Models\Genero;
use App\Models\GustoGenero;
use App\Models\Persona;
use App\Models\Preferencia;
use App\Models\PreferenciaPersona;
use Exception;
use Illuminate\Http\Request;

class controladorGeneral extends Controller
{
    public function listarGeneros(){
        return Genero::all();
    }

    public function listarPreferencias(){
        return Preferencia::all();
    }

    public function listarPersonas(){
        return Persona::all();
    }

    public function preferenciaPersona(){
        return PreferenciaPersona::all();
    }

    public function gustoGenero(){
        return GustoGenero::all();
    }

    public function registrar(Request $req){
        $correo = $req->get('correo');
        $persona = Persona::find($correo);
        if(!isset($persona)){
            $persona = Persona::create($req->all());
            //dd($persona->contraseña);
            Persona::where('correo', $correo)
            ->update(['contraseña' => md5($persona->contraseña)]);
            return response()->json(['message'=>'Datos insertados: '.$persona],201);
        }else{
            return response()->json(['message'=>'¡ADVERTENCIA: '.$persona .'No insertada'],400);
        }
    }


    public function actualizarPersona(Request $req){
        $datos = json_decode($req->getContent());
        $correo = $datos->correo;
        $tieneHijos = $datos->tieneHijos;
        $quiereHijos = $datos->quiereHijos;
        $tipoRelacion = $datos->tipoRelacion;

        try{
            Persona::where('correo', $correo)
            ->update(['tieneHijos' => $tieneHijos, 'quiereHijos' => $quiereHijos, 'tipoRelacion' => $tipoRelacion]);

            return response()->json(['message'=>'Persona actualizada: '.$correo],201);
        }
        catch(Exception $ex){
            return response()->json(['message'=>'La persona no se ha actualizado'],400);
        }
    }


    public function addPreferenciaPersona(Request $req){
        try{
            $pref = PreferenciaPersona::create($req->all());
            return response()->json(['message'=>'Preferencia añadida: '.$pref],201);
        }
        catch(Exception $ex){
            return response()->json(['message'=>'La preferencia no se ha añadido'],400);
        }
    }


    public function addGustoGenero(Request $req){
        try{
            $gustoGenero = GustoGenero::create($req->all());
            return response()->json(['message'=>'Gusto genero añadido: '.$gustoGenero],201);
        }
        catch(Exception $ex){
            return response()->json(['message'=>'El gusto genero no se ha añadido'],400);
        }
    }


    public function iniciarSesion(Request $req){
        ///dd($req->get('correo'));
        $correo = $req->get('correo');
        $contraseña = $req->get('contraseña');

        $persona = Persona::find($correo);
        if(isset($persona)){
            if($persona->contraseña == md5($contraseña)){
                $persona->conectado = 1;
                Persona::where('correo', $correo)
                ->update(['conectado' => $persona->conectado]);
                return response()->json(['message'=>'Inicio de sesión correcto: '.$persona],201);
            }else{
                return response()->json(['message'=>'Contraseña incorrecta.'],201);
            }
        }else{
            return response()->json(['message'=>'¡ADVERTENCIA: '.$persona .'No iniciada'],400);
        }
    }
}
