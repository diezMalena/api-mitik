<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\Genero;
use App\Models\GustoGenero;
use App\Models\Like;
use App\Models\Notificacion;
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
                    ->join('generos','generos.id','=','personas.id_genero')
                    ->select('personas.correo AS correo','personas.nombre AS nombre', 'personas.fechaNacimiento AS fechaNacimiento', 'personas.ciudad AS ciudad','personas.descripcion AS descripcion',
                    'personas.tipoRelacion AS tipoRelacion','personas.tieneHijos AS tieneHijos','personas.quiereHijos AS quiereHijos','personas.id_genero AS id_genero',
                    'gusto_generos.id_genero AS id_generoGusto','generos.descripcion AS descripcionGenero')
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
                    //->join('likes','likes.correo2','!=','personas.correo')  //Aqui no incluimos a la persona porque le hemos dado like antes
                    ->select('personas.correo AS correo','personas.nombre AS nombre', 'personas.fechaNacimiento AS fechaNacimiento', 'personas.ciudad AS ciudad','personas.descripcion AS descripcion',
                    'personas.tipoRelacion AS tipoRelacion','personas.tieneHijos AS tieneHijos','personas.quiereHijos AS quiereHijos','personas.id_genero AS id_genero',
                    'gusto_generos.id_genero AS id_generoGusto')
                    ->where('personas.correo','!=',$correo)
                    ->get();
        //dd($arrayPersonas);

        $arrayMediocre = array();
        $arraySuper = array();

        foreach($arrayPersonas as $per){
            //Tenemos que coger las preferencias de cada persona:
            $prefPer = DB::table('preferencias_personas')
                        ->select('id_preferencia','intensidad')
                        ->where('preferencias_personas.correo','=',$per->correo)
                        ->get();
            //dd($prefPer);

            $per->fechaNacimiento = $this->calculaEdad($per->fechaNacimiento);

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

        //dd($arraySuper);
        //return $arraySuper;

        return response()->json($arraySuper,201);
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
        if((($persona1->tieneHijos==1 && $persona2->quiereHijos==1)  || ($persona1->quiereHijos==1 && $persona2->tieneHijos==1)) || (($persona1->quiereHijos==1 && $persona2->quiereHijos==1) || ($persona1->tieneHijos==1 && $persona2->tieneHijos==1)) || (($persona1->quiereHijos==0 && $persona2->quiereHijos==0) || ($persona1->tieneHijos==0 && $persona2->tieneHijos==0))){
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

    function calculaEdad($fechaNacimiento){
        list($ano,$mes,$dia) = explode("-",$fechaNacimiento);
        $ano_diferencia  = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia   = date("d") - $dia;
        if ($dia_diferencia < 0 || $mes_diferencia < 0)
            $ano_diferencia--;
        return $ano_diferencia;
    }


    public function darLike(Request $req){
        //dd($req->all());
        $correo1 = $req->get('correo1');
        $correo2 = $req->get('correo2');
        //dd($correo2);
        $like = Like::where('correo1', $correo1)->where('correo2', $correo2)->get();
        //dd($like->isEmpty());

        //Si like está vacio, se crea:
        if($like->isEmpty()){
            $like = DB::table('likes')->insert([
                'correo1' => $correo1,
                'correo2' => $correo2
            ]);
            $likeAlContrario = Like::where('correo1', $correo2)->where('correo2', $correo1)->get();
            //dd($likeAlContrario);
            if(!$likeAlContrario->isEmpty()){
                $amigos = DB::table('amigos')->insert([
                    'correo1' => $correo1,
                    'correo2' => $correo2
                ]);


                //La primera persona le ha dado like a la segunda:
                Notificacion::create([
                    'correo' => $correo2,
                    'mensaje' => $correo1.' te ha dado like',
                    'leido' => 0,
                ]);


                //Esta notificacion es para la primera persona
                Notificacion::create([
                    'correo' => $correo1,
                    'mensaje' => 'Ya eres amigo de '. $correo2,
                    'leido' => 0,
                ]);

                //Esta notificacion es para la segunda persona
                Notificacion::create([
                    'correo' => $correo2,
                    'mensaje' => 'Ya eres amigo de '.$correo1,
                    'leido' => 0,
                ]);


                return response()->json(['message'=>'Ahora sois amigos!'],201);
            }else{


                Notificacion::create([
                    'correo' => $correo2,
                    'mensaje' => $correo1.' te ha dado like',
                    'leido' => 0,
                ]);


                return response()->json(['message'=>$correo1 .'Le ha dado like a '.$correo2],201);
            }
        }else{
            return response()->json(['message'=>'¡ADVERTENCIA: '.$like .'No insertado'],400);
        }
    }


    public function notificaciones(Request $req){
        $correo = $req->get('correo');
        //dd($correo);

        //leido = 0, la notificacion aun no la ha visto el usuario. Solo queremos coger las notificaciones que no haya leido aun.
        $notificaciones = Notificacion::where('correo', $correo)->where('leido', 0)->get();
        return response()->json($notificaciones,201);
    }


    public function cambiarLeido(Request $req){
        $correo = $req->get('correo');
        //Establecemos el leido a 1 para indicar que la notificacion ya la ha leido el usuario:
        Notificacion::where('correo', $correo)
        ->update(['leido' => 1]);

        return response()->json(['message'=>'La notificacion ha sido leida'],200);
    }
}
