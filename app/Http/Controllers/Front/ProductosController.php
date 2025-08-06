<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Producto;
use App\Models\Subcategoria;

class ProductosController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('activo', 1)->orderBy('orden', 'asc')->get();
        foreach ($categorias as $categoria) {
            $categoria->path = asset('storage/' . $categoria->path);
        }
        // Subcategorías agrupadas por categoria_id
        $subcategorias = Subcategoria::whereIn('categoria_id', $categorias->pluck('id'))
            ->where('activo', 1)
            ->orderBy('orden', 'asc')->get()
            ->groupBy('categoria_id');

        // Asignar el path público a cada subcategoría individual
        foreach ($subcategorias as $grupo) {
            foreach ($grupo as $subcategoria) {
                $subcategoria->path = asset('storage/' . $subcategoria->path);
            }
        }

        $banner = Banner::where('seccion', 'productos')->first();
        if ($banner) {
            $banner->banner = asset('storage/' . $banner->banner);
        }
        $metadatos = Metadato::where('seccion', 'productos')->first();
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }

        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.categorias', compact('categorias', 'subcategorias', 'banner', 'metadatos', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
    public function show($subcategoriaId)
    {
        $categorias = Categoria::where('activo', 1)->orderBy('orden', 'asc')->get();
        foreach ($categorias as $categoria) {
            $categoria->path = asset('storage/' . $categoria->path);
        }
        // Subcategorías agrupadas por categoria_id
        $subcategorias = Subcategoria::whereIn('categoria_id', $categorias->pluck('id'))
            ->where('activo', 1)
            ->orderBy('orden', 'asc')->get()
            ->groupBy('categoria_id');

        // Asignar el path público a cada subcategoría individual
        foreach ($subcategorias as $grupo) {
            foreach ($grupo as $subcategoria) {
                $subcategoria->path = asset('storage/' . $subcategoria->path);
            }
        }

        $subcategoria = Subcategoria::findOrFail($subcategoriaId);
        $productos = Producto::where('subcategoria_id', $subcategoria->id)
            ->where('activo', 1)
            ->orderBy('orden', 'asc')
            ->get();
        foreach ($productos as $producto) {
            $producto->path = asset('storage/' . $producto->path);
            $producto->hover = asset('storage/' . $producto->hover);
            foreach ($producto->acabados as $acabado) {
                $acabado->path = asset('storage/' . $acabado->path);
            }
        }

        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }

        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.subcategorias', compact('categorias', 'subcategorias', 'subcategoria', 'productos', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
    public function showProducto($producto)
    {
        $producto = Producto::with([
            'acabados' => function ($query) {
            $query->orderBy('orden', 'asc');
            },
            'galeria' => function ($query) {
            $query->orderBy('orden', 'asc');
            }
        ])->findOrFail($producto);

        $producto->path = asset('storage/' . $producto->path);
        if ($producto->manual) {
            $producto->manual = asset('storage/' . $producto->manual);
        }
        if ($producto->autocad) {
            $producto->autocad = asset('storage/' . $producto->autocad);
        }
        foreach ($producto->acabados as $acabado) {
            $acabado->path = asset('storage/' . $acabado->path);
        }  
        foreach ($producto->galeria as $imagen) {
            $imagen->path = asset('storage/' . $imagen->path);
        }
        $relacionados = Producto::where('subcategoria_id', $producto->subcategoria_id)
            ->where('id', '!=', $producto->id)
            ->where('activo', 1)
            ->orderBy('orden', 'asc')
            ->get();
        foreach ($relacionados as $relacionado) {
            $relacionado->path = asset('storage/' . $relacionado->path);
            $relacionado->hover = asset('storage/' . $relacionado->hover);
            foreach ($relacionado->acabados as $acabado) {
                $acabado->path = asset('storage/' . $acabado->path);
                $acabado->hover = asset('storage/' . $acabado->hover);
            }
        }
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }

        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.productos', compact('producto', 'relacionados', 'logos', 'contactos', 'whatsapp', 'redes'));
    }
}
