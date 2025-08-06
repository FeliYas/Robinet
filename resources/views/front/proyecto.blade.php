@extends('layouts.guest')

@section('title', __('Proyectos'))

@section('content')
    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $proyecto->portada }}" alt="{{ __('Banner de proyectos') }}"
                class="absolute inset-0 w-full h-full object-cover ">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1 text-center">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-lg">•</span>
                        <a href="{{ route('categorias') }}" class="hover:underline">{{ __('Proyectos') }}</a>
                        <span class="text-lg">•</span>
                        <span class="opacity-50">{{ $proyecto->titulo }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Proyectos</p>
                    <h2 class="text-[40px] font-bold text-white">{{ $proyecto->titulo }}</h2>
                </div>
            </div>
        </div>
        <div class="w-[90%] max-w-[1224px] mx-auto min-h-[70vh] py-20 text-[#1A181C] flex flex-col gap-20">
            <div class="flex flex-col lg:flex-row gap-18">
                <img src="{{ $proyecto->path }}" alt="imagen proyecto" class="w-full lg:w-1/2 object-cover h-[600px]">
                <div class="w-full lg:w-1/2 flex flex-col items-start justify-center gap-9">
                    <img src="{{ $proyecto->icono }}" alt="icono proyecto" class="h-[47px] w-auto object-contain">
                    <div class="custom-summernote text-lg font-medium">
                        <p>{!! $proyecto->descripcion !!}</p>
                    </div>
                </div>
            </div>
            @if ($proyecto->galeria->count())
                <div class="flex flex-col gap-5">
                    <div class="flex justify-between items-center">
                        <h2 class="text-[40px] font-bold">Galeria de imagenes</h2>
                        <div class="flex items-center gap-1">
                            <div id="galeriaproy-arrows" class="flex items-center gap-1" style="display:none;">
                                <button id="galeriaproy-prev" class="group cursor-pointer" aria-label="Anterior">
                                    <svg id="galeriaproy-prev-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                        height="50" viewBox="0 0 50 50" fill="none">
                                        <path d="M31.25 37.5L18.75 25L31.25 12.5" stroke="#898888" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <button id="galeriaproy-next" class="group cursor-pointer" aria-label="Siguiente">
                                    <svg id="galeriaproy-next-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                        height="50" viewBox="0 0 50 50" fill="none">
                                        <path d="M18.75 37.5L31.25 25L18.75 12.5" stroke="#DEDFE0" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div id="galeriaproy-carousel" class="overflow-hidden">
                            <div id="galeriaproy-track" class="flex transition-transform duration-500 ease-in-out gap-6">
                                @foreach ($proyecto->galeria as $imagen)
                                    <div
                                        class="h-[360px] min-w-full sm:min-w-[calc((100%_-_24px)_/_2)] flex-shrink-0 relative group">
                                        <img src="{{ $imagen->path }}" alt="imagen proyecto"
                                            class="absolute inset-0 w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black opacity-20 group-hover:opacity-40 transition-all duration-300">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const track = document.getElementById('galeriaproy-track');
                        const prevBtn = document.getElementById('galeriaproy-prev');
                        const nextBtn = document.getElementById('galeriaproy-next');
                        const prevSvg = document.getElementById('galeriaproy-prev-svg').querySelector('path');
                        const nextSvg = document.getElementById('galeriaproy-next-svg').querySelector('path');
                        const arrows = document.getElementById('galeriaproy-arrows');
                        const items = track.children;
                        let current = 0;
                        let autoDirection = 1;
                        let autoTimeout;

                        function getVisible() {
                            if (window.innerWidth >= 1024) return 2;
                            return 1;
                        }

                        function getItemWidth() {
                            return items[0].offsetWidth + 24;
                        }

                        function updateCarousel() {
                            const visible = getVisible();
                            const itemWidth = getItemWidth();
                            track.style.transform = `translateX(-${current * itemWidth}px)`;

                            if (items.length > visible) {
                                arrows.style.display = 'flex';
                            } else {
                                arrows.style.display = 'none';
                            }

                            // Colores de flechas
                            if (current === 0) {
                                prevSvg.setAttribute('stroke', '#DCDCDC');
                                nextSvg.setAttribute('stroke', '#898888');
                            } else if (current >= items.length - visible) {
                                prevSvg.setAttribute('stroke', '#898888');
                                nextSvg.setAttribute('stroke', '#DCDCDC');
                            } else {
                                prevSvg.setAttribute('stroke', '#898888');
                                nextSvg.setAttribute('stroke', '#898888');
                            }
                        }

                        function autoMove() {
                            clearTimeout(autoTimeout);
                            const visible = getVisible();
                            if (items.length <= visible) return;
                            if (autoDirection === 1) {
                                if (current < items.length - visible) {
                                    current++;
                                } else {
                                    autoDirection = -1;
                                    current--;
                                }
                            } else {
                                if (current > 0) {
                                    current--;
                                } else {
                                    autoDirection = 1;
                                    current++;
                                }
                            }
                            updateCarousel();
                            autoTimeout = setTimeout(autoMove, 5000);
                        }

                        prevBtn.addEventListener('click', () => {
                            const visible = getVisible();
                            if (current > 0) {
                                current--;
                                autoDirection = -1;
                                updateCarousel();
                                clearTimeout(autoTimeout);
                                autoTimeout = setTimeout(autoMove, 5000);
                            }
                        });
                        nextBtn.addEventListener('click', () => {
                            const visible = getVisible();
                            if (current < items.length - visible) {
                                current++;
                                autoDirection = 1;
                                updateCarousel();
                                clearTimeout(autoTimeout);
                                autoTimeout = setTimeout(autoMove, 5000);
                            }
                        });
                        window.addEventListener('resize', updateCarousel);
                        updateCarousel();
                        autoTimeout = setTimeout(autoMove, 5000);
                    });
                </script>
            @endif
            @if ($proyecto->colecciones->count())
                <div class="flex flex-col gap-5">
                    <h2 class="text-[40px] font-bold">Colecciones</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($proyecto->colecciones as $coleccion)
                            <a href="{{ route('subcategorias', $coleccion->id) }}"
                                class="h-[432px] w-full flex-shrink-0 relative flex flex-col group">
                                <img src="{{ $coleccion->path }}" alt="coleccion imagen"
                                    class="w-full h-[329px] object-cover">
                                <div
                                    class="h-[329px] absolute inset-0 bg-black opacity-30 group-hover:opacity-10 transition-all duration-300">
                                </div>
                                <div class="py-5 flex flex-col items-center justify-center gap-2">
                                    <p class="text-[#898888]">{{ $coleccion->categoria->titulo }}</p>
                                    <p class="text-2xl">{{ $coleccion->titulo }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
