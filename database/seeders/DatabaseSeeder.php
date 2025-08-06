<?php

namespace Database\Seeders;

use App\Models\AcabadosContenido;
use App\Models\Banner;
use App\Models\Calidad;
use App\Models\Contacto;
use App\Models\Contenido;
use App\Models\Internacional;
use App\Models\Logo;
use App\Models\Metadato;
use App\Models\Nosotros;
use App\Models\Tarjeta;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios
        User::create([
            'name' => 'Pablo',
            'email' => 'pablo@osole.com',
            'password' => Hash::make('pablopablo'),
            'role' => 'admin',
        ]);


        // Crear logos para las secciones
        $logoSecciones = ['login', 'dashboard', 'footer', 'navbar', 'home'];
        foreach ($logoSecciones as $seccion) {
            Logo::create([
                'path' => "logos/{$seccion}-logo.png",
                'seccion' => $seccion,
            ]);
        }

        // Crear metadatos para las secciones
        $metadatos = [
            [
                'seccion' => 'home',
                'keyword' => 'robinet, inicio, productos plásticos',
                'descripcion' => 'Página principal de robinet - Empresa líder en productos plásticos de alta calidad'
            ],
            [
                'seccion' => 'nosotros',
                'keyword' => 'empresa, historia, robinet, quienes somos',
                'descripcion' => 'Conoce más sobre robinet, nuestra historia y compromiso con la calidad'
            ],
            [
                'seccion' => 'productos',
                'keyword' => 'productos plásticos, catálogo, robinet',
                'descripcion' => 'Catálogo completo de productos plásticos de alta calidad de robinet'
            ],
            [
                'seccion' => 'proyectos',
                'keyword' => 'proyectos, soluciones plásticas, robinet',
                'descripcion' => 'Descubre los proyectos donde robinet ofrece soluciones plásticas innovadoras y de alta calidad.'
            ],
            [
                'seccion' => 'acabados',
                'keyword' => 'acabados, personalización, robinet',
                'descripcion' => 'Descubre los acabados disponibles para personalizar tus productos robinet.'
            ],
            [
                'seccion' => 'puntos de venta',
                'keyword' => 'puntos de venta, distribución, robinet',
                'descripcion' => 'Descubre nuestros puntos de venta y cómo adquirir nuestros productos.'
            ],
            [
                'seccion' => 'contacto',
                'keyword' => 'contacto, ubicación, teléfono, email robinet',
                'descripcion' => 'Información de contacto y ubicación de robinet'
            ]
        ];
        foreach ($metadatos as $metadato) {
            Metadato::create($metadato);
        }

        // Crear datos de ejemplo para nosotros
        Nosotros::create([
            'path' => 'images/nosotros-banner.jpg',
            'titulo' => 'Sobre robinet',
            'descripcion' => 'Somos una empresa líder en la fabricación de productos plásticos de alta calidad, comprometidos con la innovación y la excelencia.', 
        ]);
        // Crear tarjetas de ejemplo
        $tarjetas = [
            [
                'path' => 'images/tarjeta-productos.jpg',
                'icono' => 'images/icono-productos.png',
                'titulo' => 'Productos de Calidad',
            ],
            [
                'path' => 'images/tarjeta-innovacion.jpg',
                'icono' => 'images/icono-innovacion.png',
                'titulo' => 'Innovación Constante',
            ],
            [
                'path' => 'images/tarjeta-servicio.jpg',
                'icono' => 'images/icono-servicio.png',
                'titulo' => 'Servicio Excepcional',
            ],
        ];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
        foreach ($tarjetas as $tarjeta) {
            Tarjeta::create($tarjeta);
        }

        // Crear contenido de ejemplo
        Contenido::create([
            'path' => 'images/contenido-home-banner.jpg',
            'titulo' => 'Bienvenidos a robinet',
            'descripcion' => 'Tu socio confiable en soluciones plásticas de alta calidad para todas las industrias.'
        ]);
        
        $banners = [
            [
                'banner' => 'images/contenido-home-banner.jpg',
                'titulo' => 'Nosotros',
                'seccion' => 'nosotros'
            ],
            [
                'banner' => 'images/contenido-secundario.jpg',
                'titulo' => 'productos',
                'seccion' => 'productos'
            ],
            [
                'banner' => 'images/contenido-proyectos.jpg',
                'titulo' => 'Proyectos',
                'seccion' => 'proyectos'
            ],
            [
                'banner' => 'images/contenido-acabados.jpg',
                'titulo' => 'Acabados',
                'seccion' => 'acabados'
            ],
            [
                'banner' => 'images/contenido-puntos-venta.jpg',
                'titulo' => 'Puntos de Venta',
                'seccion' => 'puntos de venta'
            ],
            [
                'banner' => 'images/contenido-contacto.jpg',
                'titulo' => 'Contacto',
                'seccion' => 'contacto'
            ]
        ];
        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        AcabadosContenido::create([
            'path' => 'images/acabados-banner.jpg',
            'titulo' => 'Acabados Personalizados',
            'descripcion' => 'Ofrecemos una amplia gama de acabados personalizados para adaptarse a tus necesidades específicas.'
        ]);
    }
}
