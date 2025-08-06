<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $fillable = ['orden', 'path', 'titulo', 'categoria_id', 'destacado', 'activo'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
