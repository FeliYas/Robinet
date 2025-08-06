@props(['logos', 'redes'])
<nav class="w-full fixed z-50" x-data="navbarData">
    <!-- Versión móvil: Logo y menú hamburguesa -->
    <div class="bg-main-color lg:hidden">
        <div class="flex justify-between items-center h-[100px] w-[90%] max-w-[1224px] mx-auto">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset(Route::currentRouteName() == 'home' ? $logos[0]->path : $logos[1]->path) }}"
                        alt="logo" class="w-38 h-16">
                </a>
            </div>
            <div class="mt-1.5">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class=" focus:outline-none">
                    <i class="fa-solid fa-bars text-xl text-[#DCDCDC]"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="lg:hidden bg-white shadow-lg overflow-hidden transition-all duration-300 absolute w-full z-40"
        :class="mobileMenuOpen ? 'max-h-screen' : 'max-h-0'" x-cloak>
        <div class="flex flex-col px-4 py-2 text-[#DCDCDC] text-xl divide-y divide-[#DCDCDC] bg-[#1B1919]">
            <a href="{{ route('nosotros') }}" class="py-2 hover:text-[#AB8854] transition-colors duration-300">Nosotros</a>
            <a href="{{ route('categorias') }}" class="py-2 hover:text-[#AB8854] transition-colors duration-300">Productos</a>
            <a href="{{ route('proyectos') }}" class="py-2 hover:text-[#AB8854] transition-colors duration-300">Proyectos</a>
            <a href="{{ route('acabados') }}" class="py-2 hover:text-[#AB8854] transition-colors duration-300">Acabados</a>
            <a href="{{ route('puntosventa') }}" class="py-2 hover:text-[#AB8854] transition-colors duration-300">Puntos de Venta</a>
            <a href="{{ route('contacto') }}" class="py-2 hover:text-[#AB8854] transition-colors duration-300">Contacto</a>
        </div>
    </div>
    <div class="hidden lg:block w-full h-[100px] bg-[#1B1919]">
        <div class="w-[90%] max-w-[1224px] mx-auto flex justify-between items-center h-full text-[#DCDCDC]">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="18" viewBox="0 0 26 18"
                        fill="none">
                        <path d="M1.5 1.5H24.5" stroke="#DCDCDC" stroke-width="2" stroke-linecap="round" />
                        <path d="M1.5 9H24.5" stroke="#DCDCDC" stroke-width="2" stroke-linecap="round" />
                        <path d="M1.5 17H24.5" stroke="#DCDCDC" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <p class="text-lg">Menú</p>
            </div>
            <a href="{{ route('home') }}">
                <div class="relative py-4 group transition-all duration-500">
                    <img src="{{ asset($logos[2]->path) }}" alt="logo"
                        class="transition-all duration-500 group-hover:opacity-0">
                    <img src="{{ asset($logos[1]->path) }}" alt="logo hover"
                        class="absolute left-0 top-4 transition-all duration-500 opacity-0 group-hover:opacity-100"
                        style="pointer-events: none;">
                </div>
            </a>
            <div class="flex items-center gap-4.5">
                @if ($redes->pinterest)
                    <a href="{{ $redes->pinterest }}" class="group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 14 14"
                            fill="none">
                            <path
                                d="M4.928 13.678C5.6 13.881 6.279 14 7 14C8.85651 14 10.637 13.2625 11.9497 11.9497C13.2625 10.637 14 8.85651 14 7C14 6.08075 13.8189 5.17049 13.4672 4.32122C13.1154 3.47194 12.5998 2.70026 11.9497 2.05025C11.2997 1.40024 10.5281 0.884626 9.67878 0.532843C8.8295 0.18106 7.91925 0 7 0C6.08075 0 5.17049 0.18106 4.32122 0.532843C3.47194 0.884626 2.70026 1.40024 2.05025 2.05025C0.737498 3.36301 0 5.14348 0 7C0 9.975 1.869 12.53 4.508 13.538C4.445 12.992 4.382 12.089 4.508 11.466L5.313 8.008C5.313 8.008 5.11 7.602 5.11 6.958C5.11 5.992 5.712 5.271 6.398 5.271C7 5.271 7.28 5.712 7.28 6.279C7.28 6.881 6.881 7.742 6.678 8.568C6.559 9.254 7.042 9.856 7.742 9.856C8.988 9.856 9.954 8.526 9.954 6.65C9.954 4.97 8.75 3.822 7.021 3.822C5.047 3.822 3.885 5.292 3.885 6.839C3.885 7.441 4.081 8.05 4.403 8.449C4.466 8.491 4.466 8.547 4.445 8.652L4.242 9.415C4.242 9.534 4.165 9.576 4.046 9.492C3.15 9.1 2.632 7.826 2.632 6.797C2.632 4.585 4.2 2.576 7.224 2.576C9.632 2.576 11.508 4.305 11.508 6.601C11.508 9.009 10.017 10.941 7.882 10.941C7.203 10.941 6.538 10.577 6.3 10.15L5.831 11.809C5.67 12.411 5.229 13.216 4.928 13.699V13.678Z"
                                fill="#DCDCDC" class="transition-colors duration-200 group-hover:fill-[#AB8854]" />
                        </svg>
                    </a>
                @endif
                @if ($redes->facebook)
                    <a href="{{ $redes->facebook }}" class="group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 8 14"
                            fill="none">
                            <path
                                d="M7.33333 0H5.33333C4.44928 0 3.60143 0.351189 2.97631 0.976311C2.35119 1.60143 2 2.44928 2 3.33333V5.33333H0V8H2V13.3333H4.66667V8H6.66667L7.33333 5.33333H4.66667V3.33333C4.66667 3.15652 4.7369 2.98695 4.86193 2.86193C4.98695 2.7369 5.15652 2.66667 5.33333 2.66667H7.33333V0Z"
                                fill="#DCDCDC" class="transition-colors duration-200 group-hover:fill-[#AB8854]" />
                        </svg>
                    </a>
                @endif
                @if ($redes->instagram)
                    <a href="{{ $redes->instagram }}" class="group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16"
                            fill="none">
                            <path
                                d="M11.3333 4H11.34M4.33333 1H11C12.8409 1 14.3333 2.49238 14.3333 4.33333V11C14.3333 12.8409 12.8409 14.3333 11 14.3333H4.33333C2.49238 14.3333 1 12.8409 1 11V4.33333C1 2.49238 2.49238 1 4.33333 1ZM10.3333 7.24667C10.4156 7.8015 10.3208 8.36814 10.0625 8.86601C9.80417 9.36388 9.39543 9.76761 8.89442 10.0198C8.3934 10.272 7.82563 10.3597 7.27186 10.2706C6.71808 10.1815 6.20651 9.92005 5.80989 9.52344C5.41328 9.12683 5.15182 8.61525 5.06271 8.06148C4.9736 7.5077 5.06138 6.93993 5.31355 6.43892C5.56572 5.9379 5.96946 5.52916 6.46732 5.27083C6.96519 5.01249 7.53184 4.91773 8.08667 5C8.65261 5.08392 9.17657 5.34764 9.58113 5.7522C9.98569 6.15677 10.2494 6.68072 10.3333 7.24667Z"
                                stroke="#DCDCDC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="transition-colors duration-200 group-hover:stroke-[#AB8854]" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="fixed top-0 flex flex-col bg-[#1B1919] h-screen w-[700px] py-9 px-18 gap-12" x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-[-100%]"
        x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-[-100%]"
        style="display: none; z-index: 100;">
        <div class="flex items-center gap-4">
            <button class="cursor-pointer" @click="sidebarOpen = false">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
                    fill="none">
                    <path d="M22.5 7.5L7.5 22.5M7.5 7.5L22.5 22.5" stroke="#DCDCDC" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <p class="text-lg">Cerrar</p>
        </div>
        <div class="flex flex-col gap-1">
            <a href="{{ route('nosotros') }}"
                class="text-[32px] hover:text-[#AB8854] transition-colors duration-300 w-max font-light">Nosotros</a>
            <a href="{{ route('categorias') }}"
                class="text-[32px] hover:text-[#AB8854] transition-colors duration-300 w-max">Productos</a>
            <a href="{{ route('proyectos') }}"
                class="text-[32px] hover:text-[#AB8854] transition-colors duration-300 w-max">Proyectos</a>
            <a href="{{ route('acabados') }}"
                class="text-[32px] hover:text-[#AB8854] transition-colors duration-300 w-max">Acabados</a>
            <a href="{{ route('puntosventa') }}"
                class="text-[32px] hover:text-[#AB8854] transition-colors duration-300 w-max">Puntos de
                venta</a>
            <a href="{{ route('contacto') }}"
                class="text-[32px] hover:text-[#AB8854] transition-colors duration-300 w-max">Contacto</a>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('navbarData', () => ({
            scrolled: false,
            mobileMenuOpen: false,
            sidebarOpen: false,
        }));
    });
</script>
