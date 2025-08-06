@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Proyectos'))

@section('content')
    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $banner->banner }}" alt="{{ __('Banner de proyectos') }}"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1 text-center">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-lg">•</span>
                        <a href="{{ route('categorias') }}" class="opacity-50">{{ __('Proyectos') }}</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Proyectos</p>
                    <h2 class="text-[40px] font-bold text-white">Proyectos que definen nuestra excelencia</h2>
                </div>
            </div>
        </div>
        <div class="w-[90%] max-w-[1224px] mx-auto min-h-[70vh] py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($proyectos as $proyecto)
                    <div class="h-[360px] min-w-full sm:min-w-[calc((100%_-_24px)_/_2)] flex-shrink-0 relative group">
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

@endsection
