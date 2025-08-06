<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'orden',
        'path',
        'hover',
        'codigo',
        'titulo',
        'descripcion',
        'subcategoria_id',
        'manual',
        'autocad',
        'activo',
    ];

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }
    public function galeria()
    {
        return $this->hasMany(GaleriaProductos::class);
    }
    public function acabados()
    {
        return $this->belongsToMany(Acabados::class, 'productos_acabados', 'producto_id', 'acabado_id');
    }
}
