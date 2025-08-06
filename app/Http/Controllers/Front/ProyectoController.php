<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::orderBy('orden', 'asc')->get();
        foreach ($proyectos as $proyecto) {
            $proyecto->portada = asset('storage/' . $proyecto->portada);
        }

        $banner = Banner::where('seccion', 'proyectos')->first();
        if ($banner) {
            $banner->banner = asset('storage/' . $banner->banner);
        }
        $metadatos = Metadato::where('seccion', 'proyectos')->first();
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }

        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.proyectos', compact('proyectos', 'banner', 'metadatos', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
    public function show($id)
    {
        $proyecto = Proyecto::with('galeria', 'colecciones')->findOrFail($id);
        $proyecto->portada = asset('storage/' . $proyecto->portada);
        $proyecto->path = asset('storage/' . $proyecto->path);
        $proyecto->icono = asset('storage/' . $proyecto->icono);
        if ($proyecto->galeria) {
            foreach ($proyecto->galeria as $imagen) {
                $imagen->path = asset('storage/' . $imagen->path);
            }
        }
        if ($proyecto->colecciones) {
            foreach ($proyecto->colecciones as $coleccion) {
                $coleccion->path = asset('storage/' . $coleccion->path);
            }
        }

        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.proyecto', compact('proyecto', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
}
