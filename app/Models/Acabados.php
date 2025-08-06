<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acabados extends Model
{
    protected $table = 'acabados';
    protected $fillable = ['orden', 'titulo', 'descripcion', 'path'];

    public function colecciones()
    {
        return $this->belongsToMany(Subcategoria::class, 'acabados_colecciones', 'acabado_id', 'coleccion_id');
    }
}
