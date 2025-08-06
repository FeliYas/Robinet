<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function index()
    {
        $mails = Newsletter::all();
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = asset('storage/' . $logo->path);
        return Inertia::render('Admin/Newsletter', [
            'mails' => $mails,
            'logo' => $logo
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
        ]);
        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $newsletter = new Newsletter();
        $newsletter->email = $request->email;
        $newsletter->save();


        return back()->with('Email guardado exitosamente.');
    }
    public function destroy($id)
    {
        $mail = Newsletter::findOrFail($id);
        $mail->delete();


        return redirect()->route('newsletter.dashboard')->with('message', 'Email eliminado exitosamente');
    }
}
