<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;
    protected $primaryKey = ['correo1','correo2'];
    protected $table = 'amigos';
    protected $fillable = ['correo1','correo2'];
}
