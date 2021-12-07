<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferenciaPersona extends Model
{
    use HasFactory;
    protected $table = 'preferencias_personas';
    protected $fillable = ['correo','id_preferencia','intensidad'];
}
