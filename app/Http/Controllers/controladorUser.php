<?php

namespace App\Http\Controllers;
use App\Models\Genero;
use App\Models\GustoGenero;
use App\Models\Persona;
use App\Models\Preferencia;
use App\Models\PreferenciaPersona;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class controladorUser extends Controller
{
    //

    public function sugerencias(Request $req){
        $correo = $req->get('correo');
        //dd($correo);

        //Aqui cogemos todos los datos de la persona junto con el genero que quiere que le aparezca:
        $persona = DB::table('personas')
                    ->join('gusto_generos','gusto_generos.correo','=','personas.correo')
                    ->select('personas.correo AS correo','personas.nombre AS nombre', 'personas.fechaNacimiento AS fechaNacimiento', 'personas.ciudad AS ciudad','personas.descripcion AS descripcion',
                    'personas.tipoRelacion AS tipoRelacion','personas.tieneHijos AS tieneHijos','personas.quiereHijos AS quiereHijos','personas.id_genero AS id_genero',
                    'gusto_generos.id_genero AS id_generoGusto')
                    ->where('personas.correo','=',$correo)
                    ->get();
        //dd($persona);


        //Ahora, tenemos que coger las preferencias de la persona:
        $preferenciaPersona = DB::table('preferencias_personas')
                                ->select('id_preferencia','intensidad')
                                ->where('preferencias_personas.correo','=',$correo)
                                ->get();
        //dd($preferenciaPersona);


        //Cogemos a todas las personas menos la que esta dentro de la aplicacion:
        $arrayPersonas = DB::table('personas')
                    ->join('gusto_generos','gusto_generos.correo','=','personas.correo')
                    ->select('personas.correo AS correo','personas.nombre AS nombre', 'personas.fechaNacimiento AS fechaNacimiento', 'personas.ciudad AS ciudad','personas.descripcion AS descripcion',
                    'personas.tipoRelacion AS tipoRelacion','personas.tieneHijos AS tieneHijos','personas.quiereHijos AS quiereHijos','personas.id_genero AS id_genero',
                    'gusto_generos.id_genero AS id_generoGusto')
                    ->where('personas.correo','!=',$correo)
                    ->get();
        //dd($arrayPersonas);

        $arrayMediocre = [];
        $arraySuper = [];

        foreach($arrayPersonas as $per){
            //Tenemos que coger las preferencias de cada persona:
            $prefPer = DB::table('preferencias_personas')
                        ->select('id_preferencia','intensidad')
                        ->where('preferencias_personas.correo','=',$per->correo)
                        ->get();
            //dd($prefPer);

            $esAfin = $this->calcularAfinidad($persona[0],$preferenciaPersona,$per,$prefPer);

            if($esAfin == 1){
                $arrayMediocre[] = $per;
            }else{
                if($esAfin == 2){
                    $arraySuper[] = $per;
                }
            }
        }


        //Recorremos el array de las personas medio medio y las añadimos al final del array con mucha afinidad
        foreach($arrayMediocre as $mediocre){
            $arraySuper[] = $mediocre;
        }

        dd($arraySuper);
        return $arraySuper;
    }



    /**
     * La variable afin que vamos a devolver puede tener 3 valores:
     *      0: las personas no son nada afines,
     *      1: las personas no  son ni mucho ni poco afines,
     *      2: las personas tienen mucha afinidad.
     */
    public function calcularAfinidad($persona1,$prefPersona1,$persona2,$prefPersona2){
        $afin = 0;
        $arte = 0;
        $musica = 0;
        $deporte = 0;
        $politica = 0;
        $totalDiferencia = 0;
        //Primero, tenemos que comprobar los tiene y quiere hijos, el tipo de relacion y el genero que buscan las dos personas:

        //Si p1 tiene hijos y p2 quiere hijos, o p1 quiere hijos y p2 tieneHijos, o p1 y p2 quieren hijos, o p1 y p2 tienen hijos:
        if((($persona1->tieneHijos==1 && $persona2->quiereHijos==1)  || ($persona1->quiereHijos==1 && $persona2->tieneHijos==1)) || (($persona1->quiereHijos==1 && $persona2->quiereHijos==1) || ($persona1->tieneHijos==1 && $persona2->tieneHijos==1))){
            //Ahora vamos a comprobar si buscan el mismo genero, es decir, que si la p1 esta buscando hombres, el genero de la p2 tiene que ser hombre:
            if($persona1->id_generoGusto == $persona2->id_genero && $persona2->id_generoGusto == $persona1->id_genero){
                //Comprobamos que las dos personas tengan interes en el mismo tipo de relacion:
                if($persona1->tipoRelacion == $persona2->tipoRelacion){
                    //Ahora, si hemos llegado hasta aqui, toca comprobar las intensidades de las preferencias de ambas personas:
                    for($i = 0; $i < count($prefPersona1); $i++){
                        switch($prefPersona1[$i]->id_preferencia){
                            case 1:
                                $arte = abs($prefPersona1[$i]->intensidad - $prefPersona2[$i]->intensidad);
                            break;

                            case 2:
                                $musica = abs($prefPersona1[$i]->intensidad - $prefPersona2[$i]->intensidad);
                            break;

                            case 3:
                                $politica = abs($prefPersona1[$i]->intensidad - $prefPersona2[$i]->intensidad);
                            break;

                            case 4:
                                $deporte = abs($prefPersona1[$i]->intensidad - $prefPersona2[$i]->intensidad);
                            break;
                        }
                    }
                    $totalDiferencia = $arte + $musica + $politica + $deporte;
                    if($totalDiferencia <= 150){
                        //Muy afin
                        $afin = 2;
                    }else{
                        if($totalDiferencia >= 151 && $totalDiferencia <= 300){
                            //Medio medio
                            $afin = 1;
                        }else{
                            //Nada afin
                            $afin = 0;
                        }
                    }
                }
            }
        }
        return $afin;
    }
}
