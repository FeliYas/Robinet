<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'banner' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->witherrors($validator->messages()->first());
        }
        $banner = Banner::findOrFail($id);

        $imagePath = $banner->banner;

        if ($request->hasFile('banner')) {
            $ruta = $banner->banner;
            $file = $request->file('banner');
            if ($ruta && Storage::exists($ruta)) {
                Storage::delete($ruta);
            }
            $imagePath = $file->store('images');
        }

        $banner->update([
            'banner' => $imagePath,
        ]);

        return redirect()->back()->with('message', 'Banner actualizado exitosamente');
    }
}
