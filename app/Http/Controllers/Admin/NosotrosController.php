<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Logo;
use App\Models\Nosotros;
use App\Models\Tarjeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NosotrosController extends Controller
{
    public function index()
    {
        $nosotros = Nosotros::first();
        $nosotros->path = Storage::url($nosotros->path);
        $banner = Banner::where('seccion', 'nosotros')->first();
        $banner->banner = asset('storage/' . $banner->banner);
        $tarjetas = Tarjeta::all();
        foreach ($tarjetas as $tarjeta) {
            $tarjeta->path = Storage::url($tarjeta->path);
            $tarjeta->icono = Storage::url($tarjeta->icono);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Nosotros', [
            'nosotros' => $nosotros,
            'banner' => $banner,
            'tarjetas' => $tarjetas,
            'logo' => $logo,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|mimes:jpeg,png,jpg,gif,svg,mp4,avi,mov,webp|max:100000',
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:100000',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator->messages()->first());
        }
        
        $nosotros = Nosotros::findOrFail($id);
        $banner = Banner::where('seccion', 'nosotros')->first();

        // Validar y procesar la imagen si se proporciona
        $imagePath = $nosotros->path;
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            if (Storage::exists($nosotros->path)) {
                Storage::delete($nosotros->path);
            }
            $imagePath = $file->store('images');
        }


        // Validar y procesar el banner si se proporciona
        $bannerPath = $banner->banner;
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            if ($bannerPath && Storage::exists($bannerPath)) {
                Storage::delete($bannerPath);
            }
            $bannerPath = $file->store('images');
            $banner->update(['banner' => $bannerPath]);
        }

        $nosotros->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'path' => $imagePath,
        ]);

        return redirect()->route('nosotros.dashboard')->with('message', 'Nosotros actualizado exitosamente');
    }

    public function updateTarjeta(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->messages()->first());
        }

        $tarjeta = Tarjeta::findOrFail($id);
        
        $tarjeta->update([
            'titulo' => $request->titulo,
        ]);

        return redirect()->route('nosotros.dashboard')->with('message', 'Tarjeta actualizada exitosamente');
    }
}