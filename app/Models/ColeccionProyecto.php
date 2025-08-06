<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColeccionProyecto extends Model
{
    protected $table = 'colecciones_proyectos';
    protected $fillable = ['proyecto_id', 'coleccion_id'];
}
