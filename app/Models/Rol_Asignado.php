<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol_Asignado extends Model
{
    use HasFactory;
    protected $table = 'roles_asignados';
    protected $fillable = ['correo','id_rol'];
}
