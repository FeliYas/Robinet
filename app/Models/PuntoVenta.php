<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoVenta extends Model
{
    protected $table = 'puntos_venta';
    protected $fillable = [
        'orden',
        'titulo',
        'direccion',
        'telefono',
        'sitio_web',
        'latitud',
        'longitud',
    ];
}
