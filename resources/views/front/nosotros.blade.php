@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Nosotros'))

@section('content')
    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $banner->banner }}" alt="{{ __('Banner de Nosotros') }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-[#898888] text-lg">·</span>
                        <a href="{{ route('nosotros') }}" class="text-[#898888] hover:underline">{{ __('Nosotros') }}</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Nosotros</p>
                    <h2 class="text-[40px] font-bold text-white">Alta performance y diseño</h2>
                </div>
            </div>
        </div>
        <div class="bg-[#1B1919] py-20">
            <div class="w-[90%] max-w-[1224px] mx-auto flex flex-col lg:flex-row gap-18">
                <img src="{{ $nosotros->path }}" alt="{{ __('Imagen de Nosotros') }}"
                    class="lg:w-1/2 h-[400px] lg:h-[600px] object-cover">
                <div class="flex flex-col gap-3.5 lg:w-1/2 text-[#DCDCDC] justify-center">
                    <h2 class="font-bold text-[32px]">{{ $nosotros->titulo }}</h2>
                    <div class="custom-summernote text-lg">
                        <p>{!! $nosotros->descripcion !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-[#1B1919]">
            <div class="w-[90%] max-w-[1224px] mx-auto">
                <div class="flex flex-col gap-5 pb-20">
                    <h2 class="text-[#DCDCDC] text-[32px] font-semibold">{{ __('La esencia que nos define') }}</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        @foreach ($tarjetas as $tarjeta)
                            <x-tarjeta-nosotros :tarjeta="$tarjeta" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
