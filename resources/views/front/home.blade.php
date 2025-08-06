@extends('layouts.guest')
@section('title', __('Home'))

@section('content')
    <div>
        <!-- Hero Slider Section -->
        <div class="overflow-hidden">
            <div class="slider-track flex transition-transform duration-500 ease-in-out">
                @foreach ($sliders as $slider)
                    @php $ext = pathinfo($slider->path, PATHINFO_EXTENSION); @endphp
                    <div class="slider-item min-w-full relative h-[600px] lg:h-[700px]">
                        <div class="absolute inset-0 bg-black z-0 overflow-hidden">
                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ asset($slider->path) }}" alt="Slider Image" class="w-full h-full object-cover"
                                    data-duration="6000">
                            @elseif (in_array($ext, ['mp4', 'webm', 'ogg']))
                                <video class="w-full h-full object-cover" autoplay muted onended="nextSlide()">
                                    <source src="{{ asset($slider->path) }}" type="video/{{ $ext }}">
                                    {{ __('Tu navegador no soporta el formato de video.') }}
                                </video>
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-black opacity-40" style="mix-blend-mode: darken;">
                        </div>
                        <div class="absolute inset-0 flex z-20 lg:max-w-[1224px] lg:mx-auto">
                            <div
                                class="relative flex flex-col gap-4 sm:gap-6 lg:gap-10 w-full justify-center items-center text-center mb-20">
                                <div
                                    class="max-w-[320px] sm:max-w-[400px] lg:max-w-[500px] text-[#DCDCDC] flex flex-col gap-2 lg:gap-6">
                                    <h1
                                        class="text-3xl lg:text-5xl font-bold leading-tight sm:leading-normal lg:leading-14">
                                        {{ $slider->titulo }}</h1>
                                    <div class="custom-summernote text-xl sm:text-2xl mt-1">
                                        <p>{!! $slider->descripcion !!}</p>
                                    </div>
                                </div>
                                <a href="{{ route('categorias') }}"
                                    class="flex w-[148px] py-2 px-5 bg-transparent border border-white rounded-3xl items-center text-center justify-center text-xl hover:border-[#AB8854] hover:text-[#AB8854] transition-colors duration-300">Ver
                                    productos</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Slider Navigation Dots -->
            {{-- <div class="relative lg:max-w-[1224px] lg:mx-auto">
                <div class="absolute bottom-4 sm:bottom-6 lg:bottom-13 w-full z-30">
                    <div class="flex space-x-1 lg:space-x-2">
                        @foreach ($sliders as $i => $slider)
                            <button
                                class="cursor-pointer dot w-4 sm:w-6 lg:w-12 h-1 sm:h-1.5 rounded-none transition-colors duration-300 bg-white {{ $i === 0 ? 'opacity-90' : 'opacity-50' }}"
                                data-dot-index="{{ $i }}" onclick="goToSlide({{ $i }})"></button>
                        @endforeach
                    </div>
                </div>
            </div> --}}
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sliderTrack = document.querySelector('.slider-track');
                const sliderItems = document.querySelectorAll('.slider-item');
                const dots = document.querySelectorAll('.dot');
                let currentIndex = 0,
                    autoSlideTimeout, isTransitioning = false;

                window.nextSlide = () => {
                    if (isTransitioning) return;
                    clearTimeout(autoSlideTimeout);
                    currentIndex = (currentIndex + 1) % sliderItems.length;
                    updateSlider();
                };
                window.goToSlide = i => {
                    if (isTransitioning || i === currentIndex) return;
                    clearTimeout(autoSlideTimeout);
                    currentIndex = i;
                    updateSlider();
                };

                function updateSlider() {
                    isTransitioning = true;
                    sliderItems.forEach(item => item.querySelector('video')?.pause());
                    sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
                    dots.forEach((dot, i) => dot.classList.toggle('opacity-90', i === currentIndex) || dot.classList
                        .toggle('opacity-50', i !== currentIndex));
                    scheduleNextSlide();
                    setTimeout(() => isTransitioning = false, 500);
                }

                function scheduleNextSlide() {
                    clearTimeout(autoSlideTimeout);
                    const slide = sliderItems[currentIndex],
                        video = slide.querySelector('video'),
                        img = slide.querySelector('img');
                    if (video) {
                        video.currentTime = 0;
                        video.play();
                    } else autoSlideTimeout = setTimeout(window.nextSlide, img?.dataset.duration ? +img.dataset
                        .duration : 6000);
                }
                sliderItems.forEach(item => item.querySelector('video') && (item.querySelector('video').onended = window
                    .nextSlide));
                updateSlider();
            });
        </script>

        <!-- Colecciones Section -->
        <div class="py-20 bg-[#1B1919] text-[#DCDCDC]">
            <div class="flex flex-col w-[90%] max-w-[1224px] mx-auto gap-5">
                <div class="flex justify-between items-center">
                    <h2 class="text-[40px] font-bold">Colecciones</h2>
                    <div class="flex items-center gap-1">
                        <div id="coleccion-arrows" class="flex items-center gap-1" style="display:none;">
                            <button id="coleccion-prev" class="group cursor-pointer" aria-label="Anterior">
                                <svg id="coleccion-prev-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                    height="50" viewBox="0 0 50 50" fill="none">
                                    <path d="M31.25 37.5L18.75 25L31.25 12.5" stroke="#898888" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button id="coleccion-next" class="group cursor-pointer" aria-label="Siguiente">
                                <svg id="coleccion-next-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                    height="50" viewBox="0 0 50 50" fill="none">
                                    <path d="M18.75 37.5L31.25 25L18.75 12.5" stroke="#DEDFE0" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div id="coleccion-carousel" class="overflow-hidden">
                        <div id="coleccion-track" class="flex transition-transform duration-500 ease-in-out gap-6">
                            @foreach ($colecciones as $coleccion)
                                <a href="{{ route('subcategorias', $coleccion->id) }}"
                                    class="h-[432px] min-w-full sm:min-w-[calc((100%_-_24px)_/_2)] lg:min-w-[calc((100%_-_72px)_/_4)] flex-shrink-0 relative flex flex-col group">
                                    <img src="{{ $coleccion->path }}" alt="coleccion imagen"
                                        class="w-full h-[329px] object-cover">
                                    <div
                                        class="h-[329px] absolute inset-0 bg-black opacity-30 group-hover:opacity-10 transition-all duration-300">
                                    </div>
                                    <div class="py-5 flex flex-col items-center justify-center gap-2">
                                        <p class="text-[#898888]">{{ $coleccion->categoria->titulo }}</p>
                                        <p class="text-[#DCDCDC] text-2xl">{{ $coleccion->titulo }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const track = document.getElementById('coleccion-track');
                const prevBtn = document.getElementById('coleccion-prev');
                const nextBtn = document.getElementById('coleccion-next');
                const prevSvg = document.getElementById('coleccion-prev-svg').querySelector('path');
                const nextSvg = document.getElementById('coleccion-next-svg').querySelector('path');
                const arrows = document.getElementById('coleccion-arrows');
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
                        prevSvg.setAttribute('stroke', '#898888');
                        nextSvg.setAttribute('stroke', '#fff');
                    } else if (current >= items.length - visible) {
                        prevSvg.setAttribute('stroke', '#fff');
                        nextSvg.setAttribute('stroke', '#898888');
                    } else {
                        prevSvg.setAttribute('stroke', '#fff');
                        nextSvg.setAttribute('stroke', '#fff');
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

        <!-- Content Section -->
        <div class="flex flex-col lg:flex-row gap-0 lg:gap-22 bg-[#1B1919]">

            <img src="{{ $contenido->path }}" alt="{{ __('Contenido de la pagina') }}"
                class="w-full lg:w-[50vw] h-[400px] lg:h-[700px] object-cover opacity-0 -translate-x-20 transition-all duration-2000 ease-in-out scroll-fade-left">
            <div
                class="w-full h-[600px] lg:h-[700px] lg:w-1/2 pl-[5%] pr-[5%] lg:pl-0 lg:pr-[calc((100vw-1224px)/2)] py-7 flex flex-col opacity-0 translate-x-20 transition-all duration-2000 ease-in-out scroll-fade-right items-center md:items-start justify-center text-[#DCDCDC] gap-6 lg:gap-30">
                <div class="flex flex-col gap-4 sm:gap-6 w-full">
                    <h2 class="font-bold text-3xl lg:text-[40px] text-center lg:text-left">
                        {{ $contenido->titulo }}</h2>
                    <div class="custom-summernote text-center lg:text-left text-lg">
                        <p>{!! $contenido->descripcion !!}</p>
                    </div>
                </div>
                <a href="{{ route('nosotros') }}"
                    class="flex w-[148px] py-2 px-5 bg-transparent border border-white rounded-3xl items-center text-center justify-center text-xl hover:border-[#AB8854] hover:text-[#AB8854] transition-colors duration-300">{{ __('Descubrir') }}</a>
            </div>
        </div>
        <!-- Scroll Animation Script -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const element = entry.target;

                            // Remueve las clases de estado inicial
                            element.classList.remove('opacity-0');

                            // Remueve las clases de transformación según el tipo de fade
                            if (element.classList.contains('scroll-fade-left')) {
                                element.classList.remove('-translate-x-20');
                            }
                            if (element.classList.contains('scroll-fade-right')) {
                                element.classList.remove('translate-x-20');
                            }

                            // Opcional: para evitar re-observar elementos ya animados
                            observer.unobserve(element);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px' // Activa la animación un poco antes
                });

                // Observa todos los elementos con las clases de scroll fade
                document.querySelectorAll('.scroll-fade-right, .scroll-fade-left').forEach(el => {
                    observer.observe(el);
                });
            });
        </script>

        <!-- Proyectos Section -->
        <div class="py-20 bg-[#1B1919] text-[#DCDCDC]">
            <div class="flex flex-col w-[90%] max-w-[1224px] mx-auto gap-5">
                <div class="flex justify-between items-center">
                    <h2 class="text-[40px] font-bold">Proyectos</h2>
                    <div class="flex items-center gap-1">
                        <div id="proyectos-arrows" class="flex items-center gap-1" style="display:none;">
                            <button id="proyectos-prev" class="group cursor-pointer" aria-label="Anterior">
                                <svg id="proyectos-prev-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                    height="50" viewBox="0 0 50 50" fill="none">
                                    <path d="M31.25 37.5L18.75 25L31.25 12.5" stroke="#898888" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button id="proyectos-next" class="group cursor-pointer" aria-label="Siguiente">
                                <svg id="proyectos-next-svg" xmlns="http://www.w3.org/2000/svg" width="50"
                                    height="50" viewBox="0 0 50 50" fill="none">
                                    <path d="M18.75 37.5L31.25 25L18.75 12.5" stroke="#DEDFE0" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div id="proyectos-carousel" class="overflow-hidden">
                        <div id="proyectos-track" class="flex transition-transform duration-500 ease-in-out gap-6">
                            @foreach ($proyectos as $proyecto)
                                <div
                                    class="h-[360px] min-w-full sm:min-w-[calc((100%_-_24px)_/_2)] flex-shrink-0 relative group">
                                    <img src="{{ $proyecto->portada }}" alt="portada proyecto"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-black opacity-20 group-hover:opacity-40 transition-all duration-300">
                                    </div>
                                    <div class="absolute bottom-11 px-6 flex justify-between items-center w-full">
                                        <div class="flex flex-col leading-none">
                                            <p class="text-[32px] leading-none">{{ $proyecto->titulo }}</p>
                                            <p class="leading-none">{{ $proyecto->lugar }}</p>
                                        </div>
                                        <a href="{{ route('proyecto.show', $proyecto->id) }}"
                                            class="flex w-[123px] py-2 px-5 bg-transparent border border-white rounded-3xl items-center text-center justify-center text-xl hover:border-[#AB8854] hover:text-[#AB8854] transition-colors duration-300">{{ __('Ver más') }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const track = document.getElementById('proyectos-track');
                const prevBtn = document.getElementById('proyectos-prev');
                const nextBtn = document.getElementById('proyectos-next');
                const prevSvg = document.getElementById('proyectos-prev-svg').querySelector('path');
                const nextSvg = document.getElementById('proyectos-next-svg').querySelector('path');
                const arrows = document.getElementById('proyectos-arrows');
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

                    if (current === 0) {
                        prevSvg.setAttribute('stroke', '#898888');
                        nextSvg.setAttribute('stroke', '#fff');
                    } else if (current >= items.length - visible) {
                        prevSvg.setAttribute('stroke', '#fff');
                        nextSvg.setAttribute('stroke', '#898888');
                    } else {
                        prevSvg.setAttribute('stroke', '#fff');
                        nextSvg.setAttribute('stroke', '#fff');
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
    </div>


@endsection
