<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactoController extends Controller
{
    /**
     * Mostrar la página principal de contacto
     */
    public function index()
    {
        $contacto = Contacto::first();
        $banner = Banner::where('seccion', 'contacto')->first();
        $banner->banner = asset('storage/' . $banner->banner);
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = asset('storage/' . $logo->path);

        return Inertia::render('Admin/Contacto', [
            'contacto' => $contacto,
            'logo' => $logo,
            'banner' => $banner
        ]);
    }

    /**
     * Actualizar la información de contacto
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'pinterest' => 'nullable|string|max:255',
            'emailcomercial' => 'nullable|email|max:255',
            'emailtecnico' => 'nullable|email|max:255',
            'emailadmin' => 'nullable|email|max:255',
            'emaildistribuidor' => 'nullable|email|max:255',
            'banner' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:100000',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $contacto = Contacto::findOrFail($id);
        $banner = Banner::where('seccion', 'contacto')->first();

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $ruta = $banner->banner;
            $file = $request->file('banner');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            
            $imagePath = $file->store('images');
            $banner->banner = $imagePath;
            $banner->save();
        }

        $contacto->direccion = $request->direccion;
        $contacto->telefono = $request->telefono;
        $contacto->email = $request->email;
        $contacto->whatsapp = $request->whatsapp;
        $contacto->instagram = $request->instagram;
        $contacto->facebook = $request->facebook;
        $contacto->pinterest = $request->pinterest;
        $contacto->emailcomercial = $request->emailcomercial;
        $contacto->emailtecnico = $request->emailtecnico;
        $contacto->emailadmin = $request->emailadmin;
        $contacto->emaildistribuidor = $request->emaildistribuidor;

        $contacto->save();
        
        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('contacto.dashboard')->with('message', 'Contacto actualizado exitosamente');
    }
}
