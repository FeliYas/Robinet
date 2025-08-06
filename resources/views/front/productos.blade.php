@extends('layouts.guest')

@section('title', __('Productos'))

@section('content')
    <div>
        <div class="w-[90%] max-w-[1224px] mx-auto py-6">
            <div class="flex gap-1 text-[#898888] hidden lg:block">
                <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                <span class="text-lg">•</span>
                <a href="{{ route('categorias') }}" class="hover:underline">{{ __('Productos') }}</a>
                <span class="text-lg">•</span>
                <a href="{{ route('categorias') }}"
                    class="hover:underline">{{ $producto->subcategoria->categoria->titulo ?? '' }}</a>
                <span class="text-lg">•</span>

                <a href="{{ route('subcategorias', $producto->subcategoria->id) }}"
                    class="hover:underline">{{ $producto->subcategoria->titulo ?? '' }}</a>
                <span class="text-lg">•</span>
                <span class="opacity-50">{{ $producto->titulo ?? '' }}</span>
            </div>
            <div class="min-h-[80vh]">
                <div class="flex flex-col lg:flex-row gap-6 py-7 mb-6 lg:mb-0">
                    <div class="w-full lg:w-1/2">
                        <img src="{{ $producto->path ?? '' }}" alt="Producto {{ $producto->titulo }}"
                            class="h-[400px] lg:h-[590px] w-full object-cover">
                    </div>
                    <div class="flex flex-col justify-center text-[#1A181C] w-full lg:w-1/2 gap-6">
                        <div class="flex flex-col">
                            <h2 class="text-[40px] font-bold leading-none">{{ $producto->titulo ?? '' }}</h2>
                            <p class="text-xl leading-none">{{ $producto->codigo ?? '' }}</p>
                            <hr class="mt-2 mb-4 border-[#DCDCDC] w-full">
                            <div class="custom-summernote">
                                <p class="text-lg">{!! $producto->descripcion !!}</p>
                            </div>
                        </div>
                        @if ($producto->acabados->count())
                            <div class="flex flex-col gap-1.5 mt-12">
                                <p class="font-bold text-xl">Acabados standar por linea</p>

                                <!-- Select personalizado -->
                                <div class="relative">
                                    <div class="custom-select w-full">
                                        <div
                                            class="select-selected px-1 py-2 border border-[#DCDCDC] rounded-md text-[#898888] cursor-pointer flex items-center gap-1 bg-white">
                                            <img src="{{ $producto->acabados->first()->path }}"
                                                alt="{{ $producto->acabados->first()->titulo }}"
                                                class="object-cover rounded h-6 w-6">
                                            <span>{{ $producto->acabados->first()->titulo }}</span>
                                            <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        <div
                                            class="select-items absolute top-full left-0 right-0 z-50 bg-white border border-[#DCDCDC] rounded-md mt-1 hidden max-h-60 overflow-y-auto shadow-lg">
                                            @foreach ($producto->acabados as $acabado)
                                                <div class="select-option px-1 py-2 hover:bg-gray-100 cursor-pointer flex items-center gap-1 text-[#898888]"
                                                    data-value="{{ $acabado->id }}">
                                                    <img src="{{ $acabado->path }}" alt="{{ $acabado->titulo }}"
                                                        class="object-cover rounded h-6 w-6">
                                                    <span>{{ $acabado->titulo }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- Input hidden para enviar el valor seleccionado -->
                                    <input type="hidden" name="acabado_selected" id="acabado_selected"
                                        value="{{ $producto->acabados->first()->id }}">
                                </div>
                                <a href="{{route('acabados')}}" class="text-lg decoration-auto underline-offset-[25%] underline">Consultar
                                    por otros acabados</a>
                            </div>
                        @endif
                        <div class="flex flex-col gap-2">
                            <p class="font-bold text-xl">Descargas</p>
                            @if ($producto->autocad || $producto->manual)
                                <div class="flex gap-6">
                                    @if ($producto->manual)
                                        <a href="{{ $producto->manual }}"
                                            class="flex py-2 w-full px-5 bg-transparent border border-black rounded-3xl items-center text-center justify-center text-lg hover:border-[#AB8854] hover:text-[#AB8854] transition-colors duration-300">
                                            Manual
                                        </a>
                                    @endif

                                    @if ($producto->autocad)
                                        <a href="{{ $producto->autocad }}"
                                            class="flex py-2 w-full px-5 bg-transparent border border-black rounded-3xl items-center text-center justify-center text-lg hover:border-[#AB8854] hover:text-[#AB8854] transition-colors duration-300">
                                            Autocad
                                        </a>
                                    @endif
                                </div>
                            @endif
                            <a href="{{ route('contacto') }}" class="btn-primary text-lg mt-1">Consultar</a>
                        </div>
                    </div>
                </div>
                @if ($producto->galeria->count())
                    <!-- Galeria Section -->
                    <div class="flex flex-col gap-5 text-[#1A181C]">
                        <div class="flex justify-between items-center">
                            <h2 class="text-[40px] font-bold">Galeria</h2>
                            <div class="flex items-center gap-1">
                                <div id="galeria-arrows" class="flex items-center gap-1" style="display:none;">
                                    <button id="galeria-prev" class="group cursor-pointer" aria-label="Anterior">
                                        <svg id="galeria-prev-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                            height="50" viewBox="0 0 50 50" fill="none">
                                            <path d="M31.25 37.5L18.75 25L31.25 12.5" stroke="#898888" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <button id="galeria-next" class="group cursor-pointer" aria-label="Siguiente">
                                        <svg id="galeria-next-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                            height="50" viewBox="0 0 50 50" fill="none">
                                            <path d="M18.75 37.5L31.25 25L18.75 12.5" stroke="#DEDFE0" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div id="galeria-carousel" class="overflow-hidden">
                                <div id="galeria-track" class="flex transition-transform duration-500 ease-in-out gap-6">
                                    @foreach ($producto->galeria as $imagen)
                                        <div
                                            class="min-w-full sm:min-w-[calc((100%_-_24px)_/_2)] lg:min-w-[calc((100%_-_72px)_/_4)] flex-shrink-0">
                                            <img src="{{ $imagen->path }}" alt="imagen de la galería"
                                                class="h-[237px] w-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const track = document.getElementById('galeria-track');
                            const prevBtn = document.getElementById('galeria-prev');
                            const nextBtn = document.getElementById('galeria-next');
                            const prevSvg = document.getElementById('galeria-prev-svg').querySelector('path');
                            const nextSvg = document.getElementById('galeria-next-svg').querySelector('path');
                            const arrows = document.getElementById('galeria-arrows');
                            const items = track.children;
                            let current = 0;
                            let autoDirection = 1; // 1: derecha, -1: izquierda
                            let autoTimeout;

                            function getVisible() {
                                if (window.innerWidth >= 1024) return 4;
                                if (window.innerWidth >= 640) return 2;
                                return 1;
                            }

                            function getItemWidth() {
                                return items[0].offsetWidth + 24; // 24px gap-6
                            }

                            function updateCarousel() {
                                const visible = getVisible();
                                const itemWidth = getItemWidth();
                                track.style.transform = `translateX(-${current * itemWidth}px)`;

                                // Mostrar/ocultar flechas
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
                @if ($relacionados->count())
                    <div class="flex flex-col gap-5 text-[#1A181C] py-20">
                        <div class="flex justify-between items-center">
                            <h2 class="text-[40px] font-bold">También puede interesarte</h2>
                            <div class="flex items-center gap-1">
                                <div id="relacionado-arrows" class="flex items-center gap-1" style="display:none;">
                                    <button id="relacionado-prev" class="group cursor-pointer" aria-label="Anterior">
                                        <svg id="relacionado-prev-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                            height="50" viewBox="0 0 50 50" fill="none">
                                            <path d="M31.25 37.5L18.75 25L31.25 12.5" stroke="#898888" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <button id="relacionado-next" class="group cursor-pointer" aria-label="Siguiente">
                                        <svg id="relacionado-next-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                            height="50" viewBox="0 0 50 50" fill="none">
                                            <path d="M18.75 37.5L31.25 25L18.75 12.5" stroke="#DEDFE0" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <div id="relacionado-carousel" class="overflow-hidden">
                                <div id="relacionado-track"
                                    class="flex transition-transform duration-500 ease-in-out gap-6">
                                    @foreach ($relacionados as $relacionado)
                                        <div
                                            class="p-2 w-full sm:w-[calc((100%_-_24px)_/_2)] lg:w-[calc((100%_-_72px)_/_4)] flex-shrink-0">
                                            <a href="{{ route('producto.show', $relacionado->id) }}"
                                                class="h-[432px] w-full relative flex flex-col group transition-shadow duration-300 cursor-pointer"
                                                style="box-shadow: none;"
                                                onmouseover="this.style.boxShadow='0 0 8px 2px rgba(0,0,0,0.20)';"
                                                onmouseout="this.style.boxShadow='none';">
                                                <div class="relative w-full h-[329px]">
                                                    <img src="{{ asset($relacionado->path) }}"
                                                        alt="{{ $relacionado->titulo }}"
                                                        class="w-full h-full object-cover absolute inset-0 transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                                                    @if ($relacionado->hover)
                                                        <img src="{{ asset($relacionado->hover) }}"
                                                            alt="{{ $producto->titulo }} hover"
                                                            class="w-full h-full object-cover absolute inset-0 transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 p-2.5">
                                                    @endif
                                                </div>
                                                <div class="px-3 flex flex-col items-center justify-center gap-2">
                                                    <p class="text-[#898888]">
                                                        {{ $relacionado->subcategoria->categoria->titulo ?? '' }}
                                                        / <span class="text-[#AB8854]">Linea
                                                            {{ $relacionado->subcategoria->titulo ?? '' }}</span></p>
                                                    <div class="min-h-16 text-center">
                                                        <p class="text-black text-2xl line-clamp-2">
                                                            {{ $relacionado->titulo }}</p>
                                                    </div>
                                                    <hr class="border-[#DCDCDC] w-full ">
                                                    <div class="flex justify-between w-full pb-1">
                                                        <p class="text-[#898888]">Acabados standars</p>
                                                        <div class="flex">
                                                            @foreach ($relacionado->acabados as $acabado)
                                                                <img src="{{ asset($acabado->path) }}"
                                                                    alt="{{ $acabado->titulo }}"
                                                                    class="w-7 h-7 object-cover">
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const track = document.getElementById('relacionado-track');
                            const prevBtn = document.getElementById('relacionado-prev');
                            const nextBtn = document.getElementById('relacionado-next');
                            const prevSvg = document.getElementById('relacionado-prev-svg').querySelector('path');
                            const nextSvg = document.getElementById('relacionado-next-svg').querySelector('path');
                            const arrows = document.getElementById('relacionado-arrows');
                            const items = track.children;
                            let current = 0;
                            let autoDirection = 1; // 1: derecha, -1: izquierda
                            let autoTimeout;

                            function getVisible() {
                                if (window.innerWidth >= 1024) return 4;
                                if (window.innerWidth >= 640) return 2;
                                return 1;
                            }

                            function getItemWidth() {
                                return items[0].offsetWidth + 24; // 24px gap-6
                            }

                            function updateCarousel() {
                                const visible = getVisible();
                                const itemWidth = getItemWidth();
                                track.style.transform = `translateX(-${current * itemWidth}px)`;

                                // Mostrar/ocultar flechas
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
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customSelect = document.querySelector('.custom-select');
            const selectSelected = customSelect.querySelector('.select-selected');
            const selectItems = customSelect.querySelector('.select-items');
            const hiddenInput = document.getElementById('acabado_selected');

            // Toggle dropdown
            selectSelected.addEventListener('click', function() {
                selectItems.classList.toggle('hidden');
                const arrow = this.querySelector('svg');
                arrow.style.transform = selectItems.classList.contains('hidden') ? 'rotate(0deg)' :
                    'rotate(180deg)';
            });

            // Select option
            selectItems.querySelectorAll('.select-option').forEach(option => {
                option.addEventListener('click', function() {
                    const img = this.querySelector('img').cloneNode(true);
                    const text = this.querySelector('span').textContent;
                    const value = this.getAttribute('data-value');

                    // Update selected display
                    selectSelected.querySelector('img').src = img.src;
                    selectSelected.querySelector('img').alt = img.alt;
                    selectSelected.querySelector('span').textContent = text;

                    // Update hidden input
                    hiddenInput.value = value;

                    // Close dropdown
                    selectItems.classList.add('hidden');
                    const arrow = selectSelected.querySelector('svg');
                    arrow.style.transform = 'rotate(0deg)';
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!customSelect.contains(e.target)) {
                    selectItems.classList.add('hidden');
                    const arrow = selectSelected.querySelector('svg');
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>

@endsection
