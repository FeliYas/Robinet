<?php

use App\Http\Controllers\Admin\AcabadoContenidoController;
use App\Http\Controllers\Admin\AcabadoController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ContactoController;
use App\Http\Controllers\Admin\ContenidoController;
use App\Http\Controllers\Admin\GaleriaController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\MetadatoController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\NosotrosController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProyectoController;
use App\Http\Controllers\Admin\PuntoVentaController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubcategoriaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Front\AcabadoController as FrontAcabadoController;
use App\Http\Controllers\Front\ContactoController as FrontContactoController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NosotrosController as FrontNosotrosController;
use App\Http\Controllers\Front\ProductosController;
use App\Http\Controllers\Front\ProyectoController as FrontProyectoController;
use App\Http\Controllers\Front\PuntoVentaController as FrontPuntoVentaController;
use App\Models\Logo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/nosotros', [FrontNosotrosController::class, 'index'])->name('nosotros');
Route::get('/productos', [ProductosController::class, 'index'])->name('categorias');
Route::get('/productos/{subcategoria}', [ProductosController::class, 'show'])->name('subcategorias');
Route::get('/producto/{producto}', [ProductosController::class, 'showProducto'])->name('producto.show');
Route::get('/proyectos', [FrontProyectoController::class, 'index'])->name('proyectos');
Route::get('/proyectos/{proyecto}', [FrontProyectoController::class, 'show'])->name('proyecto.show');
Route::get('/acabados', [FrontAcabadoController::class, 'index'])->name('acabados');
Route::get('/puntos-de-venta', [FrontPuntoVentaController::class, 'index'])->name('puntosventa');
Route::get('/contacto', [FrontContactoController::class, 'index'])->name('contacto');
Route::post('/contacto/enviar', [FrontContactoController::class, 'enviar'])->name('contacto.enviar');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.store');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/adm', function () {
        $logo = Logo::where('seccion', 'dashboard')->first();
        $logo->path = Storage::url($logo->path);
        return Inertia::render('Admin/Dashboard', [
            'logo' => $logo,
        ]);
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/admin/banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
    
    Route::get('/admin/home/slider', [SliderController::class, 'index'])->name('slider.dashboard');
    Route::post('/admin/home/slider/store', [SliderController::class, 'store'])->name('slider.store');
    Route::post('/admin/home/slider/update/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/admin/home/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    
    //rutas de los contenidos del dashboard
    Route::get('/admin/home/contenido', [ContenidoController::class, 'index'])->name('contenido.dashboard');
    Route::post('/admin/home/contenido/update/{id}', [ContenidoController::class, 'update'])->name('contenido.update');

    //rutas de las nosotros del dashboard// Rutas para el controlador de Nosotros
    Route::get('/admin/nosotros', [NosotrosController::class, 'index'])->name('nosotros.dashboard');
    Route::post('/admin/nosotros/update/{id}', [NosotrosController::class, 'update'])->name('nosotros.update');
    Route::put('/admin/nosotros/tarjeta/update/{id}', [NosotrosController::class, 'updateTarjeta'])->name('tarjeta.update');

    

    //rutas de los productos del dashboard
    Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('categorias.dashboard');
    Route::post('/admin/categorias/store', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/admin/categorias/update/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/admin/categorias/delete/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::post('/admin/categorias/activo', [CategoriaController::class, 'toggleActivo'])->name('categorias.toggleActivo');
    Route::get('/admin/subcategorias', [SubcategoriaController::class, 'index'])->name('subcategorias.dashboard');
    Route::post('/admin/subcategorias/store', [SubcategoriaController::class, 'store'])->name('subcategorias.store');
    Route::put('/admin/subcategorias/update/{id}', [SubcategoriaController::class, 'update'])->name('subcategorias.update');
    Route::delete('/admin/subcategorias/delete/{id}', [SubcategoriaController::class, 'destroy'])->name('subcategorias.destroy');
    Route::post('/admin/subcategorias/activo', [SubcategoriaController::class, 'toggleActivo'])->name('subcategorias.toggleActivo');
    Route::post('/admin/subcategorias/destacado', [SubcategoriaController::class, 'toggleDestacado'])->name('subcategorias.toggleDestacado');
    Route::get('/admin/productos', [ProductoController::class, 'index'])->name('productos.dashboard');
    Route::post('/admin/productos/store', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/admin/productos/update/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/admin/productos/delete/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::post('/admin/productos/activo', [ProductoController::class, 'toggleActivo'])->name('productos.toggleActivo');
    Route::post('/admin/galeria/update', [GaleriaController::class, 'update'])->name('galeria.update');
    Route::delete('/admin/galeria/destroy/{id}', [GaleriaController::class, 'destroy'])->name('galeria.destroy');

    //proyectos
    Route::get('/admin/proyectos', [ProyectoController::class, 'index'])->name('proyectos.dashboard');
    Route::post('/admin/proyectos/store', [ProyectoController::class, 'store'])->name('proyectos.store');
    Route::put('/admin/proyectos/update/{id}', [ProyectoController::class, 'update'])->name('proyectos.update');
    Route::delete('/admin/proyectos/delete/{id}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');
    Route::post('/admin/proyectos/destacado', [ProyectoController::class, 'toggleDestacado'])->name('proyectos.toggleDestacado');

    //acabados
    Route::get('/admin/acabados', [AcabadoController::class, 'index'])->name('acabados.dashboard');
    Route::post('/admin/acabados/store', [AcabadoController::class, 'store'])->name('acabados.store');
    Route::put('/admin/acabados/update/{id}', [AcabadoController::class, 'update'])->name('acabados.update');
    Route::delete('/admin/acabados/delete/{id}', [AcabadoController::class, 'destroy'])->name('acabados.destroy');
    Route::get('/admin/acabados/contenido', [AcabadoContenidoController::class, 'index'])->name('acabadoscontenido.dashboard');
    Route::post('/admin/acabados/contenido/update/{id}', [AcabadoContenidoController::class, 'update'])->name('acabadoscontenido.update');

    //puntos de venta
    Route::get('/admin/puntos', [PuntoVentaController::class, 'index'])->name('puntos.dashboard');
    Route::post('/admin/puntos/store', [PuntoVentaController::class, 'store'])->name('puntos.store');
    Route::put('/admin/puntos/update/{id}', [PuntoVentaController::class, 'update'])->name('puntos.update');
    Route::delete('/admin/puntos/delete/{id}', [PuntoVentaController::class, 'destroy'])->name('puntos.destroy');

    //rutas del contacto del dashboard
    Route::get('/admin/contacto', [ContactoController::class, 'index'])->name('contacto.dashboard');
    Route::post('/admin/contacto/update/{id}', [ContactoController::class, 'update'])->name('contacto.update');
    
    //rutas de los logos del dashboard
    Route::get('/admin/logos', [LogoController::class, 'index'])->name('logos.dashboard');
    Route::put('/admin/logos/update/{id}', [LogoController::class, 'update'])->name('logos.update');

    //rutas del newsletter del dashboard
    Route::get('/admin/newsletter', [NewsletterController::class, 'index'])->name('newsletter.dashboard');
    Route::delete('/admin/newsletter/destroy/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');

    //rutas de usuarios del dashboard
    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('usuarios.dashboard');
    Route::post('/admin/usuarios/create', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/admin/usuarios/edit/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/admin/usuarios/delete/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    //rutas de los metadatos
    Route::get('/admin/metadatos', [MetadatoController::class, 'index'])->name('metadatos.dashboard');
    Route::put('/admin/metadatos/update/{id}', [MetadatoController::class, 'update'])->name('metadatos.update');
});

require __DIR__.'/auth.php';
