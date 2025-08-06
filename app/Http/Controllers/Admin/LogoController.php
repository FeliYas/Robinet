<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::all();
        foreach ($logos as $logo) {
            $logo->path = Storage::url($logo->path);
        }
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);

        return inertia('Admin/Logo', [
            'logos' => $logos,
            'logo' => $logo,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'path' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048', // Cambiado 'image' por 'file'
            'seccion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $logo = Logo::find($id);

        if ($request->hasFile('path')) {
            $ruta= $logo->path;
            $file = $request->file('path');
            if (Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath=$file->store('images');
            
        }

        $logo->seccion = $request->seccion ?? $logo->seccion;
        $logo->path = $imagePath ?? $logo->path;
        $logo->save();
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('logos.dashboard')->with('message', 'Logo actualizado exitosamente');
    }
}
