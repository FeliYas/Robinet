<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoAcabado extends Model
{
    protected $table = 'productos_acabados';
    protected $fillable = ['producto_id', 'acabado_id'];
}
