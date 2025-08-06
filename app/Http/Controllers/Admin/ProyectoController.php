<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\ColeccionProyecto;
use App\Models\Logo;
use App\Models\Proyecto;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::orderBy('orden', 'asc')->with('colecciones', 'galeria')->get();
        foreach ($proyectos as $proyecto) {
            $proyecto->path = Storage::url($proyecto->path);
            $proyecto->portada = Storage::url($proyecto->portada);
            $proyecto->icono = Storage::url($proyecto->icono);
            foreach ($proyecto->galeria as $imagen) {
                $imagen->path = Storage::url($imagen->path);
            }
        }
        $colecciones = Subcategoria::whereHas('categoria', function ($query) {
            $query->where('titulo', 'Colecciones');
        })->get();
        foreach ($colecciones as $coleccion) {
            $coleccion->path = Storage::url($coleccion->path);
        }
        $banner = Banner::where('seccion', 'proyectos')->first();
        $banner->banner = Storage::url($banner->banner);
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Proyectos', [
            'proyectos' => $proyectos,
            'colecciones' => $colecciones,
            'banner' => $banner,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $agregados = $request->agregados ? array_filter(explode(',', $request->agregados)) : [];
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'portada' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icono' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'lugar' => 'required|string|max:255',
            'agregados' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $imagePath = null;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imagePath = $file->store('images');
        }
        $iconoPath = null;
        if ($request->hasFile('icono')) {
            $file = $request->file('icono');
            $iconoPath = $file->store('images');
        }
        $portadaPath = null;
        if ($request->hasFile('portada')) {
            $file = $request->file('portada');
            $portadaPath = $file->store('images');
        }

        $proyecto = Proyecto::create(array_filter([
            'orden' => $request->orden,
            'portada' => $portadaPath,
            'icono' => $iconoPath,
            'path' => $imagePath,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'lugar' => $request->lugar,
        ]));

        // Procesar agregados (colecciones)
        foreach ($agregados as $coleccion_id) {
            ColeccionProyecto::create([
                'proyecto_id' => $proyecto->id,
                'coleccion_id' => $coleccion_id,
            ]);
        }

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('proyectos.dashboard')->with('message', 'Proyecto creado exitosamente');
    }
    public function update(Request $request, $id)
    {
        $agregados = $request->agregados ? array_filter(explode(',', $request->agregados)) : [];
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icono' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'lugar' => 'required|string|max:255',
            'agregados' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $proyecto = Proyecto::find($id);

        $imagePath = $proyecto->path;
        if ($request->hasFile('path')) {
            $ruta = $proyecto->path;
            $file = $request->file('path');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $imagePath = $file->store('images');
        }

        $iconoPath = $proyecto->icono;
        if ($request->hasFile('icono')) {
            $ruta = $proyecto->icono;
            $file = $request->file('icono');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $iconoPath = $file->store('images');
        }

        $portadaPath = $proyecto->portada;
        if ($request->hasFile('portada')) {
            $ruta = $proyecto->portada;
            $file = $request->file('portada');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $portadaPath = $file->store('images');
        }

        $proyecto->update(array_filter([
            'orden' => $request->orden ?? $proyecto->orden,
            'portada' => $portadaPath,
            'icono' => $iconoPath,
            'path' => $imagePath,
            'titulo' => $request->titulo ?? $proyecto->titulo,
            'descripcion' => $request->descripcion ?? $proyecto->descripcion,
            'lugar' => $request->lugar ?? $proyecto->lugar,
        ]));
        $proyecto->save();

        ColeccionProyecto::where('proyecto_id', $proyecto->id)->delete();
        foreach ($agregados as $coleccion_id) {
            ColeccionProyecto::create([
                'proyecto_id' => $proyecto->id,
                'coleccion_id' => $coleccion_id,
            ]);
        }

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('proyectos.dashboard')->with('message', 'Proyecto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        if ($proyecto->path) {
            if (Storage::exists($proyecto->path)) {
                Storage::delete($proyecto->path);
            }
        }
        if ($proyecto->portada) {
            if (Storage::exists($proyecto->portada)) {
                Storage::delete($proyecto->portada);
            }
        }
        if ($proyecto->icono) {
            if (Storage::exists($proyecto->icono)) {
                Storage::delete($proyecto->icono);
            }
        }
        $proyecto->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('proyectos.dashboard')->with('message', 'Proyecto eliminado exitosamente');
    }
    public function toggleDestacado(Request $request)
    {
        $proyecto = Proyecto::findOrFail($request->id);
        $proyecto->destacado = $request->destacado ? 1 : 0;
        $proyecto->save();

        if ($proyecto->destacado == 1) {
            return redirect()->route('proyectos.dashboard')->with('message', 'Proyecto destacado exitosamente');
        } else {
            return redirect()->route('proyectos.dashboard')->with('message', 'Proyecto quitado de destacados exitosamente');
        }
    }
}
