@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Puntos de Venta'))

@section('content')
    <style>
        .punto-info {
            transition: all 0.3s ease;
        }

        .punto-info:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .punto-activo {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FFA500;
        }

        /* Contenedor del mapa - CRÍTICO */
        .map-container {
            position: relative;
            width: 100%;
            height: 600px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            background: #333;
        }

        /* Mapa específico */
        #map {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: 1;
        }

        /* Contenedor de Leaflet */
        .leaflet-container {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }

        /* Tiles del mapa */
        .leaflet-tile-container {
            position: absolute !important;
        }

        .leaflet-tile {
            position: absolute !important;
        }

        /* Popups */
        .leaflet-popup-content-wrapper {
            background: #2a2a2a;
            color: #DCDCDC;
        }

        .leaflet-popup-tip {
            background: #2a2a2a;
        }



        /* Filtro para hacer el mapa gris */
        .leaflet-tile-pane {
            filter: grayscale(100%) brightness(0.6) contrast(1.2);
        }

        /* Forzar que todo se mantenga dentro del contenedor */
        .map-container * {
            box-sizing: border-box;
        }
    </style>

    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $banner->banner }}" alt="{{ __('Banner de Puntos de Venta') }}"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-[#898888] text-lg">·</span>
                        <a href="{{ route('puntosventa') }}"
                            class="text-[#898888] hover:underline">{{ __('Puntos de Venta') }}</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Puntos de Venta</p>
                    <h2 class="text-[40px] font-bold text-white">Encontrá tu distribuidor mas cercano</h2>
                </div>
            </div>
        </div>
        <div class="bg-[#1B1919]">
            <div class="w-[90%] max-w-[1224px] mx-auto text-[#DCDCDC] py-6 items-start">
                <div
                    class="border border-[#898888] w-full md:w-1/2 rounded-[30px] flex justify-between items-center px-6 py-3">
                    <input type="text" id="searchInput" placeholder="Buscar por provincia, localidad, barrio, dirección"
                        class="bg-transparent text-[#DCDCDC] placeholder-[#898888] w-full outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <path
                            d="M21 21L16.7 16.7M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"
                            stroke="#DCDCDC" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
            <hr class="border-[#312F2F]">
            <div class="w-[90%] max-w-[1224px] mx-auto py-15">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Lista de puntos de venta -->
                    <div class="lg:w-1/3">
                        <div class="divide-y divide-[#312F2F] max-h-[600px] overflow-y-auto border-y border-[#312F2F]">
                            @foreach ($puntos as $punto)
                                <div class="punto-info px-2 py-4 cursor-pointer flex flex-col text-[#898888]"
                                    data-lat="{{ $punto->latitud }}" data-lng="{{ $punto->longitud }}"
                                    data-id="{{ $punto->id }}" data-titulo="{{ strtolower($punto->titulo) }}"
                                    data-direccion="{{ strtolower($punto->direccion) }}"
                                    data-sitio-web="{{ strtolower($punto->sitio_web ?? '') }}"
                                    data-telefono="{{ $punto->telefono ?? '' }}">
                                    <h4 class="text-xl text-[#DCDCDC]">{{ $punto->titulo }}</h4>
                                    <p>{{ $punto->direccion }}</p>
                                    <p class="break-all underline">
                                        {{ $punto->sitio_web }}
                                    </p>
                                    <p class="break-all underline">
                                        {{ $punto->telefono }}
                                    </p>
                                    <a href="{{ $punto->sitio_web }}" target="_blank"
                                        class="text-[#FFA500] text-sm hover:underline">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="lg:w-2/3">
                        <div class="map-container">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar que Leaflet esté cargado
            if (typeof L === 'undefined') {
                console.error('Leaflet no está cargado');
                return;
            }

            // Esperar un poco más para asegurar que el DOM esté completamente listo
            setTimeout(function() {
                // Coordenadas de Buenos Aires como centro por defecto
                const defaultLat = -34.6037;
                const defaultLng = -58.3816;

                // Limpiar cualquier instancia previa del mapa
                const mapContainer = document.getElementById('map');
                mapContainer.innerHTML = '';

                // Inicializar el mapa con configuración específica
                const map = L.map('map', {
                    center: [defaultLat, defaultLng],
                    zoom: 11,
                    zoomControl: true,
                    scrollWheelZoom: true,
                    doubleClickZoom: true,
                    boxZoom: true,
                    keyboard: true,
                    dragging: true,
                    touchZoom: true,
                    maxBounds: null,
                    maxBoundsViscosity: 0.0
                });

                // Agregar tiles del mapa (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19,
                    tileSize: 256,
                    zIndex: 1
                }).addTo(map);

                // Forzar el tamaño correcto del mapa
                map.getContainer().style.height = '600px';
                map.getContainer().style.width = '100%';

                // Invalidar tamaño para asegurar renderizado correcto  
                setTimeout(() => {
                    map.invalidateSize(true);
                }, 100);

                // Datos de los puntos de venta desde PHP (solo campos necesarios)
                const puntos = [
                    @foreach ($puntos as $punto)
                        {
                            id: {{ $punto->id }},
                            nombre: "{{ addslashes($punto->nombre) }}",
                            direccion: "{{ addslashes($punto->direccion) }}",
                            latitud: {{ $punto->latitud ?? 'null' }},
                            longitud: {{ $punto->longitud ?? 'null' }},
                            telefono: "{{ addslashes($punto->telefono ?? '') }}",
                            email: "{{ addslashes($punto->email ?? '') }}",
                            sitio_web: "{{ addslashes($punto->sitio_web ?? '') }}"
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ];

                const markers = {};

                // Crear un grupo de marcadores
                const markersGroup = L.featureGroup();

                // Agregar marcadores al mapa
                puntos.forEach(function(punto) {
                    if (punto.latitud && punto.longitud && !isNaN(punto.latitud) && !isNaN(punto
                            .longitud)) {
                        // Crear marcador personalizado con SVG
                        const customIcon = L.divIcon({
                            className: 'custom-marker',
                            iconSize: [18, 18],
                            iconAnchor: [12, 18],
                            popupAnchor: [0, -24],
                            html: `<svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                                <path d="M41.6663 20.8334C41.6663 31.2354 30.1268 42.0688 26.2518 45.4146C25.8908 45.6861 25.4513 45.8328 24.9997 45.8328C24.548 45.8328 24.1086 45.6861 23.7476 45.4146C19.8726 42.0688 8.33301 31.2354 8.33301 20.8334C8.33301 16.4131 10.089 12.1738 13.2146 9.04824C16.3402 5.92263 20.5794 4.16669 24.9997 4.16669C29.4199 4.16669 33.6592 5.92263 36.7848 9.04824C39.9104 12.1738 41.6663 16.4131 41.6663 20.8334Z" fill="#AB8854"/>
                                <path d="M25 27.0833C28.4518 27.0833 31.25 24.2851 31.25 20.8333C31.25 17.3815 28.4518 14.5833 25 14.5833C21.5482 14.5833 18.75 17.3815 18.75 20.8333C18.75 24.2851 21.5482 27.0833 25 27.0833Z" fill="white"/>
                            </svg>`
                        });

                        const marker = L.marker([parseFloat(punto.latitud), parseFloat(punto
                            .longitud)], {
                            icon: customIcon
                        });

                        // Crear contenido del popup
                        let popupContent = `
                        <div class="p-3">
                            <h4 class="font-bold text-lg mb-2">${punto.nombre}</h4>
                            <p class="mb-2">${punto.direccion}</p>
                    `;

                        if (punto.telefono && punto.telefono.trim() !== '') {
                            popupContent +=
                                `<p class="mb-1"><i class="fas fa-phone mr-2"></i>${punto.telefono}</p>`;
                        }

                        if (punto.email && punto.email.trim() !== '') {
                            popupContent +=
                                `<p class="mb-1"><i class="fas fa-envelope mr-2"></i>${punto.email}</p>`;
                        }

                        if (punto.sitio_web && punto.sitio_web.trim() !== '') {
                            let url = punto.sitio_web.trim();
                            if (!/^https?:\/\//i.test(url)) {
                                url = 'https://' + url;
                            }
                            popupContent +=
                                `<p><a href="${url}" target="_blank" class="text-orange-400 hover:underline"><i class="fas fa-globe mr-2"></i>Sitio web</a></p>`;
                        }

                        popupContent += '</div>';

                        marker.bindPopup(popupContent);
                        marker.addTo(map);
                        markersGroup.addLayer(marker);

                        // Guardar referencia del marcador
                        markers[punto.id] = marker;
                    }
                });

                // Ajustar la vista del mapa para mostrar todos los marcadores
                if (markersGroup.getLayers().length > 0) {
                    setTimeout(() => {
                        map.fitBounds(markersGroup.getBounds(), {
                            padding: [20, 20]
                        });
                    }, 100);
                }

                // Función para filtrar puntos de venta
                function filtrarPuntos(searchTerm) {
                    const puntosInfo = document.querySelectorAll('.punto-info');
                    const term = searchTerm.toLowerCase().trim();

                    // Limpiar marcadores actuales del mapa
                    markersGroup.clearLayers();

                    let puntosVisibles = [];

                    puntosInfo.forEach(function(elemento) {
                        const titulo = elemento.dataset.titulo;
                        const direccion = elemento.dataset.direccion;
                        const sitioWeb = elemento.dataset.sitioWeb;
                        const telefono = elemento.dataset.telefono;

                        // Buscar en todos los campos
                        const coincide = titulo.includes(term) ||
                            direccion.includes(term) ||
                            sitioWeb.includes(term) ||
                            telefono.includes(term);

                        if (term === '' || coincide) {
                            elemento.style.display = 'flex';

                            // Reagregar marcador al mapa si tiene coordenadas válidas
                            const id = elemento.dataset.id;
                            if (markers[id]) {
                                markersGroup.addLayer(markers[id]);
                                puntosVisibles.push(markers[id]);
                            }
                        } else {
                            elemento.style.display = 'none';
                        }
                    });

                    // Ajustar vista del mapa a los puntos visibles
                    if (puntosVisibles.length > 0) {
                        setTimeout(() => {
                            map.fitBounds(markersGroup.getBounds(), {
                                padding: [20, 20]
                            });
                        }, 100);
                    }
                }

                // Configurar el buscador
                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('input', function() {
                    filtrarPuntos(this.value);
                });

                // Agregar interactividad a la lista de puntos
                function configurarEventosPuntos() {
                    const puntosInfo = document.querySelectorAll('.punto-info');

                    puntosInfo.forEach(function(elemento) {
                        // Remover eventos anteriores
                        elemento.replaceWith(elemento.cloneNode(true));
                    });

                    // Reconfigurar eventos con los elementos actualizados
                    const puntosInfoActualizados = document.querySelectorAll('.punto-info');

                    puntosInfoActualizados.forEach(function(elemento) {
                        elemento.addEventListener('click', function() {
                            const lat = parseFloat(this.dataset.lat);
                            const lng = parseFloat(this.dataset.lng);
                            const id = this.dataset.id;

                            if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
                                // Centrar el mapa en el punto seleccionado
                                map.setView([lat, lng], 15);

                                // Abrir el popup del marcador
                                if (markers[id]) {
                                    markers[id].openPopup();
                                }

                                // Destacar el elemento seleccionado
                                puntosInfoActualizados.forEach(el => el.classList.remove(
                                    'punto-activo'));
                                this.classList.add('punto-activo');
                            }
                        });
                    });
                }

                // Configurar eventos iniciales
                configurarEventosPuntos();

                // Agregar control de ubicación del usuario (opcional)
                if (navigator.geolocation) {
                    const locationButton = L.control({
                        position: 'topleft'
                    });

                    locationButton.onAdd = function(map) {
                        const div = L.DomUtil.create('div',
                            'leaflet-bar leaflet-control leaflet-control-custom');
                        div.innerHTML =
                            '<button style="background-color: white; width: 30px; height: 30px; border: none; cursor: pointer;" title="Mi ubicación"><i class="fas fa-location-arrow"></i></button>';

                        div.onclick = function() {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                const userLat = position.coords.latitude;
                                const userLng = position.coords.longitude;

                                // Agregar marcador de ubicación del usuario
                                const userIcon = L.divIcon({
                                    className: 'user-location-marker',
                                    html: '<i class="fas fa-user" style="color: #007cff; font-size: 16px;"></i>',
                                    iconSize: [20, 20],
                                    iconAnchor: [10, 10]
                                });

                                L.marker([userLat, userLng], {
                                    icon: userIcon
                                }).addTo(map).bindPopup('Tu ubicación');

                                map.setView([userLat, userLng], 13);
                            }, function(error) {
                                console.error('Error obteniendo ubicación:', error);
                            });
                        };

                        return div;
                    };

                    locationButton.addTo(map);
                }

                // Invalidar el tamaño del mapa después de que se cargue completamente
                setTimeout(() => {
                    map.invalidateSize(true);
                }, 500);

                // Escuchar cambios de tamaño de ventana
                window.addEventListener('resize', function() {
                    setTimeout(() => {
                        map.invalidateSize(true);
                    }, 100);
                });

            }, 100); // Timeout inicial para esperar el DOM
        });
    </script>
@endsection
