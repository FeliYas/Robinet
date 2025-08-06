<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcabadosContenido extends Model
{
    protected $table = 'acabados_contenido';
    protected $fillable = ['path', 'titulo', 'descripcion'];

}