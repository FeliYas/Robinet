<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = asset('storage/' . $logo->path);
        // Mostrar la vista con los usuarios
        if (Auth::user()->role !== 'admin') {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
        return inertia('Admin/Usuarios', [
            'usuarios' => $usuarios,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        // Validar los datos enviados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        // Crear el nuevo usuario
        $usuario = new User();
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = Hash::make($request->input('password'));
        $usuario->role = $request->input('role');

        // Guardar el nuevo usuario en la base de datos
        $usuario->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('usuarios.dashboard')->with('message', 'Usuario creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        // Validar los datos enviados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,user',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }

        // Buscar el usuario a actualizar
        $usuario = User::findOrFail($id);

        // Actualizar los campos del usuario
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->role = $request->input('role');

        // Actualizar la contraseña solo si se proporcionó una nueva
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->input('password'));
        }

        // Guardar los cambios en la base de datos
        $usuario->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('usuarios.dashboard')->with('message', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Buscar el usuario a eliminar
        $usuario = User::findOrFail($id);

        // Eliminar el usuario
        $usuario->delete();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('usuarios.dashboard')->with('message', 'Usuario eliminado exitosamente');
    }
}
