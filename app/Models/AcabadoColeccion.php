<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcabadoColeccion extends Model
{
    protected $table = 'acabados_colecciones';
    protected $fillable = ['acabado_id', 'coleccion_id'];
}
