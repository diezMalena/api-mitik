<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GustoGenero extends Model
{
    use HasFactory;
    protected $table = 'gusto_generos';
    protected $fillable = ['correo','id_genero'];
}
