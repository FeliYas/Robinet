<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriaProyectos extends Model
{
    protected $fillable = [
        'orden',
        'path',
        'proyecto_id',
    ];
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
