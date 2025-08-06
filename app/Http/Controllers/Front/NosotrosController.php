<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Nosotros;
use App\Models\Tarjeta;
use Illuminate\Http\Request;

class NosotrosController extends Controller
{
    public function index()
    {
        $nosotros = Nosotros::first();
        $nosotros->path = asset('storage/' . $nosotros->path);
        $banner = Banner::where('seccion', 'nosotros')->first();
        if ($banner) {
            $banner->banner = asset('storage/' . $banner->banner);
        }
        $tarjetas = Tarjeta::all();
        foreach ($tarjetas as $tarjeta) {
            $tarjeta->path = asset('storage/' . $tarjeta->path);
            $tarjeta->icono = asset('storage/' . $tarjeta->icono);
        }
        $metadatos = Metadato::where('seccion', 'nosotros')->first();
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.nosotros', compact('nosotros', 'banner', 'tarjetas', 'metadatos', 'redes', 'logos', 'contactos', 'whatsapp'));
    }
}
