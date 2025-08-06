<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenido;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContenidoController extends Controller
{
    public function index()
    {
        $contenido = Contenido::first();
        if ($contenido->path) {
            $contenido->path = Storage::url($contenido->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Contenido', [
            'contenido' => $contenido,
            'logo' => $logo
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,webp|max:100000',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        
        $contenido = Contenido::findOrFail($id);

        if ($request->hasFile('path')) {
            $ruta= $contenido->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images'); 
        }

        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->path = $imagePath ?? $contenido->path;

        $contenido->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('contenido.dashboard')->with('message', 'Contenido actualizado exitosamente');
    }
}
