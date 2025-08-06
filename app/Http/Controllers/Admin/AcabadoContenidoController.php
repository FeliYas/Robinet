<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcabadosContenido;
use App\Models\Banner;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AcabadoContenidoController extends Controller
{
    public function index()
    {
        $contenido = AcabadosContenido::first();
        $contenido->path = Storage::url($contenido->path);
        $banner = Banner::where('seccion', 'acabados')->first();
        $banner->banner = Storage::url($banner->banner);
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/AcabadosContenido', [
            'contenido' => $contenido,
            'banner' => $banner,
            'logo' => $logo
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $contenido = AcabadosContenido::find($id);

        $imagePath = $contenido->path;
        if ($request->hasFile('path')) {
            $ruta = $contenido->path;
            $file = $request->file('path');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $imagePath = $file->store('images');
        }


        $contenido->update(array_filter([
            'path' => $imagePath,
            'titulo' => $request->titulo ?? $contenido->titulo,
            'descripcion' => $request->descripcion ?? $contenido->descripcion,
        ]));
        $contenido->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('acabadoscontenido.dashboard')->with('message', 'Contenido de acabados actualizado exitosamente');
    }
}
