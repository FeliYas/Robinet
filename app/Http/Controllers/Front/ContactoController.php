<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactoMail;
use App\Models\Banner;
use App\Models\Contacto;
use App\Models\Logo;
use App\Models\Metadato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function index()
    {
        $contacto = Contacto::first();
        $banner = Banner::where('seccion', 'contacto')->first();
        if ($banner) {
            $banner->banner = asset('storage/' . $banner->banner);
        }
        $metadatos = Metadato::where('seccion', 'contacto')->first();
        $logos = Logo::whereIn('seccion', ['home', 'navbar', 'footer'])->get();
        foreach ($logos as $logo) {
            $logo->path = asset('storage/' . $logo->path);
        }
        $redes = Contacto::select('facebook', 'instagram','pinterest')->first();
        $contactos = Contacto::select('direccion', 'email', 'telefono')->get();
        $whatsapp = Contacto::select('whatsapp')->first()->whatsapp;
        return view('front.contacto', compact('contacto', 'banner', 'metadatos', 'logos', 'redes', 'contactos', 'whatsapp'));
    }
    public function enviar(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'area_seleccionada' => [
                'required',
                'string',
                'in:Comercial,Repuestos y Servicio Técnico,Administración,Distribuidores'
            ],
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'localidad' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'empresa' => 'nullable|string|max:100',
            'mensaje' => 'nullable|string',
            'g-recaptcha-response' => 'required'
        ]);

        // Verificar el token de reCAPTCHA
        $recaptcha = $this->verificarRecaptcha($request->input('g-recaptcha-response'));

        if (!$recaptcha['success']) {
            return redirect()->back()
                ->withErrors(['recaptcha' => 'La verificación de seguridad ha fallado. Por favor, inténtalo de nuevo.'])
                ->withInput();
        }

        // Si el score es muy bajo (posible bot), puedes rechazar la solicitud
        if ($recaptcha['score'] < 0.7) {
            return redirect()->back()
                ->withErrors(['recaptcha' => 'La verificación de seguridad ha detectado actividad sospechosa. Por favor, inténtalo de nuevo más tarde.'])
                ->withInput();
        }

        if ($validated['area_seleccionada'] === 'Repuestos y Servicio Técnico') {
            $contacto = Contacto::first()->emailtecnico;
        } elseif ($validated['area_seleccionada'] === 'Comercial') {
            $contacto = Contacto::first()->emailcomercial;
        } elseif ($validated['area_seleccionada'] === 'Administración') {
            $contacto = Contacto::first()->emailadmin;
        } elseif ($validated['area_seleccionada'] === 'Distribuidores') {
            $contacto = Contacto::first()->emaildistribuidor;
        } else {
            $contacto = Contacto::first()->email;
        }


        if (!$contacto) {
            return redirect()->back()->with('error', 'No se encontró un contacto con el tipo "email".');
        }
        
        // Enviar el correo
        Mail::to($contacto)->send(new ContactoMail($validated));
     
        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto a la brevedad.');
    }
    private function verificarRecaptcha($token)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $token,
            'remoteip' => request()->ip()
        ]);

        return $response->json();
    }
}
