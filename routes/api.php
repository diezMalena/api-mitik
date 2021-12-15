<?php

use App\Http\Controllers\controladorGeneral;
use App\Http\Controllers\controladorUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('generos',[controladorGeneral::class,'listarGeneros']);
Route::get('preferencias',[controladorGeneral::class,'listarPreferencias']);
Route::get('personas',[controladorGeneral::class,'listarPersonas']);
Route::get('preferenciaPersona',[controladorGeneral::class,'preferenciaPersona']);
Route::get('gustoGenero',[controladorGeneral::class,'gustoGenero']);

Route::group(['middleware' => ['Cors']], function () {
    //Rutas a las que se permitirá acceso
    Route::post('registrar',[controladorGeneral::class,'registrar']);
    Route::put('actualizarPersona',[controladorGeneral::class,'actualizarPersona']);
    Route::post('addPreferenciaPersona',[controladorGeneral::class,'addPreferenciaPersona']);
    Route::post('addGustoGenero',[controladorGeneral::class,'addGustoGenero']);
    Route::post('iniciarSesion',[controladorGeneral::class,'iniciarSesion']);

    Route::any('sugerencias',[controladorUser::class,'sugerencias']);
    Route::post('darLike',[controladorUser::class,'darLike']);
    Route::post('notificaciones',[controladorUser::class,'notificaciones']);
    Route::post('cambiarLeido',[controladorUser::class,'cambiarLeido']);
    Route::any('amigosConectados',[controladorUser::class,'amigosConectados']);

});



