<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Acabados;
use App\Models\AcabadosContenido;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;

class AcabadoController extends Controller
{
    public function index()
    {
        $contenido = AcabadosContenido::first();
        if ($contenido) {
            $contenido->path = asset('storage/' . $contenido->path);
        }
        $acabados = Acabados::orderBy('orden', 'asc')->get();
        foreach ($acabados as $acabado) {
            $acabado->path = asset('storage/' . $acabado->path);
            foreach ($acabado->colecciones as $coleccion) {
                $coleccion->path = asset('storage/' . $coleccion->path);
            }
        }
        $banner = Banner::where('seccion', 'acabados')->first();
        if ($banner) {
            $banner->banner = asset('storage/' . $banner->banner);
        }
        $metadatos = Metadato::where('seccion', 'acabados')->first();
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.acabados', compact('contenido', 'acabados', 'banner', 'metadatos', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
}
