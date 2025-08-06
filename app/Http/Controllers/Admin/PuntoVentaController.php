<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Logo;
use App\Models\PuntoVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PuntoVentaController extends Controller
{
    public function index()
    {
        $puntos = PuntoVenta::orderBy('orden', 'asc')->get();
        $banner = Banner::where('seccion', 'puntos de venta')->first();
        $banner->banner = Storage::url($banner->banner);
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/PuntosVenta', [
            'puntos' => $puntos,
            'banner' => $banner,
            'logo' => $logo,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'sitio_web' => 'nullable|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        $punto = PuntoVenta::create(array_filter([
            'orden' => $request->orden,
            'titulo' => $request->titulo,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'sitio_web' => $request->sitio_web,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ]));

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('puntos.dashboard')->with('message', 'Punto de venta creado exitosamente');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'sitio_web' => 'nullable|string|max:255',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $punto = PuntoVenta::find($id);

        $punto->update(array_filter([
            'orden' => $request->orden ?? $punto->orden,
            'titulo' => $request->titulo ?? $punto->titulo,
            'direccion' => $request->direccion ?? $punto->direccion,
            'telefono' => $request->telefono ?? $punto->telefono,
            'sitio_web' => $request->sitio_web ?? $punto->sitio_web,
            'latitud' => $request->latitud ?? $punto->latitud,
            'longitud' => $request->longitud ?? $punto->longitud,
        ]));
        $punto->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('puntos.dashboard')->with('message', 'Punto de venta actualizado exitosamente');
    }

    public function destroy($id)
    {
        $punto = PuntoVenta::findOrFail($id);

        $punto->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('puntos.dashboard')->with('message', 'Punto de venta eliminado exitosamente');
    }
}
