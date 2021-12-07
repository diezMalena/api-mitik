<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;


    //Aquí descomentamos todo porque la tabla tiene las características por defecto de Eloquent.
    protected $primaryKey = 'correo';
    protected $keyType = 'string';
    protected $fillable = ['correo','nombre','contraseña','fechaNacimiento','ciudad','descripcion','tipoRelacion','foto','tieneHijos','quiereHijos','conectado','activado','tema','id_genero'];
}
