<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('orden', 'asc')->get();
        $banner = Banner::where('seccion', 'productos')->first();
        $banner->banner = Storage::url($banner->banner);
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Categorias', [
            'categorias' => $categorias,
            'banner' => $banner,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $categoria = Categoria::create(array_filter([
            'orden' => $request->orden,
            'titulo' => $request->titulo,
        ]));

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria creada exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $categoria = Categoria::find($id);

        $categoria->update(array_filter([
            'orden' => $request->orden ?? $categoria->orden,
            'titulo' => $request->titulo ?? $categoria->titulo,
        ]));
        $categoria->save();
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria actualizada exitosamente');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('categorias.dashboard')->with('message', 'Categoria eliminada exitosamente');
    }
    public function toggleActivo(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->activo = $request->activo ? 1 : 0;
        $categoria->save();

        if ($categoria->activo == 1) {
            return redirect()->route('categorias.dashboard')->with('message', 'Categoria activada exitosamente');
        } else {
            return redirect()->route('categorias.dashboard')->with('message', 'Categoria desactivada exitosamente');
        }
    }
}
