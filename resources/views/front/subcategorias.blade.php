@extends('layouts.guest')

@section('title', __('Productos'))

@section('content')
    <div>
        <div class="w-[90%] max-w-[1224px] mx-auto mt-6 hidden lg:block">
            <div class="flex gap-1 text-[#898888]">
                <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                <span class="text-lg">•</span>
                <a href="{{ route('categorias') }}" class="hover:underline">{{ __('Productos') }}</a>
                <span class="text-lg">•</span>
                <a href="{{ route('categorias') }}" class="hover:underline">{{ $subcategoria->categoria->titulo ?? '' }}</a>
                <span class="text-lg">•</span>
                <span class="opacity-50">{{ $subcategoria->titulo ?? '' }}</span>
            </div>
        </div>
        <div class="w-[90%] max-w-[1224px] mx-auto py-10 lg:py-20 flex flex-col lg:flex-row gap-6 min-h-[80vh]">
            <div class="w-full lg:w-1/4 flex flex-col text-[#4A4A4A] text-left border-t border-[#DCDCDC]">
                @foreach ($categorias as $categoria)
                    <div>
                        <div
                            class="w-full border-b border-[#DCDCDC] py-2 text-2xl font-bold text-left flex justify-between items-center">
                            <p
                                class="{{ isset($subcategoria) && $subcategoria->categoria_id == $categoria->id ? 'text-black' : '' }}">
                                {{ $categoria->titulo }}</p>
                        </div>
                        @if (isset($subcategorias[$categoria->id]))
                            <ul class="flex flex-col">
                                @foreach ($subcategorias[$categoria->id] as $i => $subcat)
                                    <li>
                                        <a href="{{ route('subcategorias', $subcat->id) }}"
                                            class="block px-2 py-1 text-xl text-[#4A4A4A] hover:text-[#AB8854] transition-colors {{ isset($subcategoria) && $subcategoria->id == $subcat->id ? 'font-bold text-black' : '' }}">
                                            {{ $subcat->titulo }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="w-full lg:w-3/4 grid grid-cols-1 lg:grid-cols-3 gap-6 min-h-[200px]">
                @if (isset($productos) && count($productos))
                    @foreach ($productos as $producto)
                        <a href="{{ route('producto.show', $producto->id) }}"
                            class="h-[432px] w-full relative flex flex-col group transition-shadow duration-300 cursor-pointer"
                            style="box-shadow: none;" onmouseover="this.style.boxShadow='0 0 8px 2px rgba(0,0,0,0.20)';"
                            onmouseout="this.style.boxShadow='none';">
                            <div class="relative w-full h-[329px]">
                                <img src="{{ asset($producto->path) }}" alt="{{ $producto->titulo }}"
                                    class="w-full h-full object-cover absolute inset-0 transition-opacity duration-500 ease-in-out opacity-100 group-hover:opacity-0">
                                @if ($producto->hover)
                                    <img src="{{ asset($producto->hover) }}" alt="{{ $producto->titulo }} hover"
                                        class="w-full h-full object-cover absolute inset-0 transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 p-2.5">
                                @endif
                            </div>
                            <div class="px-3 flex flex-col items-center justify-center gap-2">
                                <p class="text-[#898888]">{{ $subcategoria->categoria->titulo ?? '' }} / <span
                                        class="text-[#AB8854]">Linea {{ $subcategoria->titulo ?? '' }}</span></p>
                                <div class="min-h-16 text-center">
                                    <p class="text-black text-2xl line-clamp-2">{{ $producto->titulo }}</p>
                                </div>
                                <hr class="border-[#DCDCDC] w-full ">
                                <div class="flex justify-between w-full pb-1">
                                    <p class="text-[#898888]">Acabados standars</p>
                                    <div class="flex">
                                        @foreach ($producto->acabados as $acabado)
                                            <img src="{{ asset($acabado->path) }}" alt="{{ $acabado->titulo }}"
                                                class="w-7 h-7 object-cover">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="col-span-3 flex items-center justify-center">
                        <div class="text-[#898888] text-xl w-full flex items-center justify-center py-10">No hay productos
                            para esta subcategoría.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
