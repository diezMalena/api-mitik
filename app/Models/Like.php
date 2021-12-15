<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $primaryKey = ['correo1','correo2'];
    protected $table = 'likes';
    protected $fillable = ['correo1','correo2'];
}
