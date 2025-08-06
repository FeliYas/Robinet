<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\PuntoVenta;
use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    public function index()
    {
        $puntos = PuntoVenta::orderBy('orden', 'asc')->get();
        $banner = Banner::where('seccion', 'puntos de venta')->first();
        if ($banner) {
            $banner->banner = asset('storage/' . $banner->banner);
        }
        $metadatos = Metadato::where('seccion', 'puntos de venta')->first();
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.puntos', compact('puntos', 'banner', 'metadatos', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
}
