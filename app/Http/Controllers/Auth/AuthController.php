<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function index()
    {
        $logo = Logo::where('seccion', 'login')->first();
        $logo->path = Storage::url($logo->path);
        return Inertia::render('Auth/Login', [
            'logo' => $logo,
        ]);
    }

    /**
     * Manejar un intento de inicio de sesión
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Intenta autenticar verificando si login es un email o un nombre de usuario
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $attemptData = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($attemptData, $request->remember)) {
            $request->session()->regenerate();

            // Obtener la URL intencionada
            $intendedUrl = session()->pull('url.intended', '/adm');

            // Comprobar si la URL intencionada es la página de login
            if ($intendedUrl === url('/login') || $intendedUrl === '/login') {
                return redirect('/adm');
            }

            // Redirigir a la URL intencionada
            return redirect($intendedUrl);
        }

        return back()->withErrors([
            'login' => 'Las credenciales son incorrectas.',
        ]);
    }

    /**
     * Cerrar la sesión del usuario
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
