<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Metadato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MetadatoController extends Controller
{
    public function index()
    {
        $meta = Metadato::all();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = asset('storage/' . $logo->path);
        return inertia('Admin/Metadatos', [
            'metadatos' => $meta,
            'logo' => $logo
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'seccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'keyword' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $meta = Metadato::find($id);
        $meta->seccion = $request->seccion;
        $meta->descripcion = $request->descripcion;
        $meta->keyword = $request->keyword;
        $meta->save();


        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('metadatos.dashboard')->with('message', 'Metadato actualizado exitosamente');
    }
}
