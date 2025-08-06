<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcabadoColeccion;
use App\Models\Acabados;
use App\Models\Banner;
use App\Models\Logo;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AcabadoController extends Controller
{
    public function index()
    {
        $acabados = Acabados::orderBy('orden', 'asc')->with('colecciones')->get();
        foreach ($acabados as $acabado) {
            $acabado->path = Storage::url($acabado->path);
        }
        $colecciones = Subcategoria::whereHas('categoria', function ($query) {
            $query->where('titulo', 'Colecciones');
        })->get();
        foreach ($colecciones as $coleccion) {
            $coleccion->path = Storage::url($coleccion->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Acabados', [
            'acabados' => $acabados,
            'colecciones' => $colecciones,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $agregados = $request->agregados ? array_filter(explode(',', $request->agregados)) : [];
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
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

        $acabado = Acabados::create(array_filter([
            'orden' => $request->orden,
            'path' => $imagePath,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]));

        // Procesar agregados (colecciones)
        foreach ($agregados as $coleccion_id) {
            AcabadoColeccion::create([
                'acabado_id' => $acabado->id,
                'coleccion_id' => $coleccion_id,
            ]);
        }

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('acabados.dashboard')->with('message', 'Acabado creado exitosamente');
    }
    public function update(Request $request, $id)
    {
        $agregados = $request->agregados ? array_filter(explode(',', $request->agregados)) : [];
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'agregados' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $acabado = Acabados::find($id);

        $imagePath = $acabado->path;
        if ($request->hasFile('path')) {
            $ruta = $acabado->path;
            $file = $request->file('path');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $imagePath = $file->store('images');
        }


        $acabado->update(array_filter([
            'orden' => $request->orden ?? $acabado->orden,
            'path' => $imagePath,
            'titulo' => $request->titulo ?? $acabado->titulo,
            'descripcion' => $request->descripcion ?? $acabado->descripcion,
        ]));
        $acabado->save();

        AcabadoColeccion::where('acabado_id', $acabado->id)->delete();
        foreach ($agregados as $coleccion_id) {
            AcabadoColeccion::create([
                'acabado_id' => $acabado->id,
                'coleccion_id' => $coleccion_id,
            ]);
        }

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('acabados.dashboard')->with('message', 'Acabado actualizado exitosamente');
    }

    public function destroy($id)
    {
        $acabado = Acabados::findOrFail($id);
        if ($acabado->path) {
            if (Storage::exists($acabado->path)) {
                Storage::delete($acabado->path);
            }
        }

        $acabado->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('acabados.dashboard')->with('message', 'Acabado eliminado exitosamente');
    }
}
