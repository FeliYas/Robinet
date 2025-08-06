<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Acabados;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Logo;
use App\Models\Producto;
use App\Models\ProductoAcabado;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('orden', 'asc')->with('acabados', 'galeria')->get();
        foreach ($productos as $producto) {
            $producto->path = Storage::url($producto->path);
            if ($producto->hover) {
                $producto->hover = Storage::url($producto->hover);
            }
            if ($producto->manual) {
            $producto->manual = Storage::url($producto->manual);
            }
            if ($producto->autocad) {
            $producto->autocad = Storage::url($producto->autocad);
            }
            foreach ($producto->galeria as $imagen) {
                $imagen->path = Storage::url($imagen->path);
            }
        }
        $acabados = Acabados::orderBy('orden', 'asc')->get();
        foreach ($acabados as $acabado) {
            $acabado->path = Storage::url($acabado->path);
        }
        $subcategorias = Subcategoria::orderBy('orden', 'asc')->get();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return inertia('Admin/Productos', [
            'productos' => $productos,
            'acabados' => $acabados,
            'subcategorias' => $subcategorias,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $agregados = $request->agregados ? array_filter(explode(',', $request->agregados)) : [];
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'codigo' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'manual' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'autocad' => 'nullable|mimes:pdf,dwg,dxf|max:15360',
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
        $hoverPath = null;
        if ($request->hasFile('hover')) {
            $file = $request->file('hover');
            $hoverPath = $file->store('images');
        }
        $manualPath = null;
        if ($request->hasFile('manual')) {
            $file = $request->file('manual');
            $manualPath = $file->store('fichas');
        }
        $autocadPath = null;
        if ($request->hasFile('autocad')) {
            $file = $request->file('autocad');
            $autocadPath = $file->store('fichas');
        }

        $producto = Producto::create(array_filter([
            'orden' => $request->orden,
            'path' => $imagePath,
            'hover' => $hoverPath,
            'codigo' => $request->codigo,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'subcategoria_id' => $request->subcategoria_id,
            'manual' => $manualPath,
            'autocad' => $autocadPath,
            'activo' => true, // Por defecto, el producto está activo
        ]));

        foreach ($agregados as $acabado_id) {
            ProductoAcabado::create([
                'producto_id' => $producto->id,
                'acabado_id' => $acabado_id,
            ]);
        }

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('productos.dashboard')->with('message', 'Producto creado exitosamente');
    }
    public function update(Request $request, $id)
    {
        $agregados = $request->agregados ? array_filter(explode(',', $request->agregados)) : [];
        $validator = Validator::make($request->all(), [
            'orden' => 'required|string|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'codigo' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'subcategoria_id' => 'required|exists:subcategorias,id',
            'manual' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'autocad' => 'nullable|mimes:pdf,dwg,dxf|max:15360',
            'agregados' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $producto = Producto::find($id);

        $imagePath = $producto->path;
        if ($request->hasFile('path')) {
            $ruta = $producto->path;
            $file = $request->file('path');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $imagePath = $file->store('images');
        }
        $hoverPath = $producto->hover;
        if ($request->hasFile('hover')) {
            $ruta = $producto->hover;
            $file = $request->file('hover');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $hoverPath = $file->store('images');
        }
        $manualPath = $producto->manual;
        if ($request->hasFile('manual')) {
            $ruta = $producto->manual;
            $file = $request->file('manual');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $manualPath = $file->store('fichas');
        }
        $autocadPath = $producto->autocad;
        if ($request->hasFile('autocad')) {
            $ruta = $producto->autocad;
            $file = $request->file('autocad');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $autocadPath = $file->store('fichas');
        }

        $producto->update(array_filter([
            'orden' => $request->orden ?? $producto->orden,
            'path' => $imagePath,
            'hover' => $hoverPath,
            'codigo' => $request->codigo ?? $producto->codigo,
            'titulo' => $request->titulo ?? $producto->titulo,
            'descripcion' => $request->descripcion ?? $producto->descripcion,
            'subcategoria_id' => $request->subcategoria_id ?? $producto->subcategoria_id,
            'manual' => $manualPath,
            'autocad' => $autocadPath,
        ]));
        $producto->save();

        ProductoAcabado::where('producto_id', $producto->id)->delete();
        foreach ($agregados as $acabado_id) {
            ProductoAcabado::create([
                'producto_id' => $producto->id,
                'acabado_id' => $acabado_id,
            ]);
        }

        return redirect()->route('productos.dashboard')->with('message', 'Producto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->path) {
            if (Storage::exists($producto->path)) {
                Storage::delete($producto->path);
            }
        }
        if ($producto->hover) {
            if (Storage::exists($producto->hover)) {
                Storage::delete($producto->hover);
            }
        }
        if ($producto->manual) {
            if (Storage::exists($producto->manual)) {
                Storage::delete($producto->manual);
            }
        }
        if ($producto->autocad) {
            if (Storage::exists($producto->autocad)) {
                Storage::delete($producto->autocad);
            }
        }
        $producto->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('productos.dashboard')->with('message', 'Producto eliminado exitosamente');
    }
    public function toggleActivo(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->activo = $request->activo ? 1 : 0;
        $producto->save();

        if ($producto->activo == 1) {
            return redirect()->route('productos.dashboard')->with('message', 'Producto activado exitosamente');
        } else {
            return redirect()->route('productos.dashboard')->with('message', 'Producto desactivado exitosamente');
        }
    }
}
