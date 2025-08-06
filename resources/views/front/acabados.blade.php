@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Acabados'))

@section('content')
    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $banner->banner }}" alt="{{ __('Banner de Acabados') }}" class="absolute inset-0 w-full h-full object-cover object-bottom">
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-[#898888] text-lg">·</span>
                        <a href="{{ route('acabados') }}" class="text-[#898888] hover:underline">{{ __('Acabados') }}</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Acabados</p>
                    <h2 class="text-[40px] font-bold text-white">Conocé todas nuestras colecciones</h2>
                </div>
            </div>
        </div>
        <div class="w-[90%] max-w-[1224px] mx-auto py-20 text-[#1A181C] flex flex-col gap-20">
            <div class="flex flex-col lg:flex-row gap-18">
                <img src="{{ $contenido->path }}" alt="{{ __('Imagen de contenido') }}"
                    class="lg:w-1/2 h-[600px] object-cover">
                <div class="flex flex-col gap-3.5 lg:w-1/2 justify-center">
                    <h2 class="font-bold text-[32px]">{{ $contenido->titulo }}</h2>
                    <div class="custom-summernote text-lg">
                        <p>{!! $contenido->descripcion !!}</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col border-b border-[#DCDCDC] divide-y divide-[#DCDCDC]" x-data="{ open: null }">
                @foreach ($acabados as $acabado)
                    <div>
                        <div class="flex justify-between items-center py-1 cursor-pointer"
                            @click="open === {{ $acabado->id }} ? open = null : open = {{ $acabado->id }}">
                            <h2 class="text-[32px] font-bold">{{ $loop->iteration }}- {{ $acabado->titulo }}</h2>
                            <div>
                                <template x-if="open !== {{ $acabado->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19M12 5V19" stroke="#898888" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </template>
                                <template x-if="open === {{ $acabado->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19" stroke="#898888" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </template>
                            </div>
                        </div>
                        <div x-show="open === {{ $acabado->id }}"
                            x-transition:enter="transition-all ease-out duration-500"
                            x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-[1000px]"
                            x-transition:leave="transition-all ease-in duration-300"
                            x-transition:leave-start="opacity-100 max-h-[1000px]" x-transition:leave-end="opacity-0 max-h-0"
                            style="overflow:hidden;">
                            <div class="flex flex-col lg:flex-row gap-17 py-6 border-t border-[#DCDCDC]">
                                <img src="{{ $acabado->path }}" alt="acabado image" class="w-full lg:w-1/5 h-[236px] object-cover">
                                <div class="flex flex-col gap-6 w-full lg:w-4/5">
                                    <div class="custom-summernote text-lg">
                                        <p>{!! $acabado->descripcion !!}</p>
                                    </div>
                                    @if ($acabado->colecciones->count())
                                        <div class="flex flex-col gap-1">
                                            <p class="font-bold text-xl">Colecciones</p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                                @foreach ($acabado->colecciones as $coleccion)
                                                    <a href="{{ route('subcategorias', $coleccion->id) }}"
                                                        class="h-[432px] w-full flex-shrink-0 relative flex flex-col group">
                                                        <img src="{{ $coleccion->path }}" alt="coleccion imagen"
                                                            class="w-full h-[329px] object-cover">
                                                        <div
                                                            class="h-[329px] absolute inset-0 bg-black opacity-30 group-hover:opacity-10 transition-all duration-300">
                                                        </div>
                                                        <div class="py-5 flex flex-col items-center justify-center gap-2">
                                                            <p class="text-[#898888]">{{ $coleccion->categoria->titulo }}
                                                            </p>
                                                            <p class="text-2xl">{{ $coleccion->titulo }}</p>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
