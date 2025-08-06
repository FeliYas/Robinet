<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = [
        'orden',
        'portada',
        'path',
        'icono',
        'titulo',
        'descripcion',
        'lugar',
        'destacado',
    ];
    public function colecciones()
    {
        return $this->belongsToMany(Subcategoria::class, 'colecciones_proyectos', 'proyecto_id', 'coleccion_id');
    }
    public function galeria()
    {
        return $this->hasMany(GaleriaProyectos::class);
    }
}
