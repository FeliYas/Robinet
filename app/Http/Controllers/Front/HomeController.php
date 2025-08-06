<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Contenido;
use App\Models\Logo;
use App\Models\Novedad;
use App\Models\Producto;
use App\Models\Proyecto;
use App\Models\Servicio;
use App\Models\Slider;
use App\Models\Subcategoria;
use App\Models\Trabajo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $sliders = Slider::orderBy('orden', 'asc')->get();
        foreach ($sliders as $slider) {
            $slider->path = asset('storage/' . $slider->path);
        }
        $colecciones = Subcategoria::where('destacado', 1)
            ->where('activo', 1)
            ->orderBy('orden', 'asc')
            ->get();
        foreach ($colecciones as $coleccion) {
            $coleccion->path = asset('storage/' . $coleccion->path);
        }
        $contenido = Contenido::first();
        if ($contenido && $contenido->path) {
            $contenido->path = asset('storage/' . $contenido->path);
        }
        $proyectos = Proyecto::where('destacado', 1)->orderBy('orden', 'asc')->get();
        foreach ($proyectos as $proyecto) {
            $proyecto->portada = asset('storage/' . $proyecto->portada);
        }
        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.home', compact(
            'logos',
            'sliders',
            'colecciones',
            'contenido',
            'proyectos',
            'redes',
            'contactos',
            'whatsapp'
        ));

    }
}
