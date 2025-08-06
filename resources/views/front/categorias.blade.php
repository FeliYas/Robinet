@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Productos'))

@section('content')
    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $banner->banner }}" alt="{{ __('Banner de productos') }}"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1 text-center">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-lg">•</span>
                        <a href="{{ route('categorias') }}" class=" hover:underline">{{ __('Productos') }}</a>
                        <span class="text-lg">•</span>
                        <span class="opacity-50">{{ $categorias->first()->titulo ?? '' }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Productos</p>
                    <h2 class="text-[40px] font-bold text-white">Conocé todas nuestras colecciones</h2>
                </div>
            </div>
        </div>
        <div class="w-[90%] max-w-[1224px] mx-auto py-20 flex flex-col lg:flex-row gap-6 min-h-[80vh]" x-data="{
            open: {{ $categorias->first()->id ?? 'null' }},
            subcats: {{ collect($subcategorias)->map(function ($items) {
                    return $items->values();
                })->values()->flatten(1)->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'titulo' => $s->titulo,
                        'path' => $s->path,
                        'categoria_id' => $s->categoria_id,
                        'categoria_titulo' => optional($s->categoria)->titulo,
                    ];
                })->values()->toJson() }}
        }">
            <div class="w-full lg:w-1/4 flex flex-col text-[#4A4A4A] text-left border-t border-[#DCDCDC]">
                @foreach ($categorias as $categoria)
                    <div>
                        <button
                            class="w-full border-b border-[#DCDCDC] py-2 text-2xl font-bold text-left flex justify-between items-center focus:outline-none"
                            @click="open === {{ $categoria->id }} ? open = null : open = {{ $categoria->id }}">
                            <p :class="open === {{ $categoria->id }} ? 'text-black' : ''">{{ $categoria->titulo }}</p>
                            <div class="cursor-pointer">
                                <template x-if="open !== {{ $categoria->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19M12 5V19" stroke="#898888" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </template>
                                <template x-if="open === {{ $categoria->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19" stroke="#898888" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </template>
                            </div>
                        </button>
                        <div x-show="open === {{ $categoria->id }}"
                            x-transition:enter="transition-all ease-out duration-700"
                            x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-96"
                            x-transition:leave="transition-all ease-in duration-400"
                            x-transition:leave-start="opacity-100 max-h-96" x-transition:leave-end="opacity-0 max-h-0"
                            style="overflow:hidden;" class="border-b border-[#DCDCDC]">
                            @if (isset($subcategorias[$categoria->id]))
                                <ul class="flex flex-col">
                                    @foreach ($subcategorias[$categoria->id] as $i => $subcat)
                                        <li x-data="{ show: false }" x-init="setTimeout(() => show = true, 100 + {{ $i }} * 80)" x-show="show"
                                            x-transition:enter="transition duration-300"
                                            x-transition:enter-start="opacity-0 translate-x-4"
                                            x-transition:enter-end="opacity-100 translate-x-0"
                                            x-transition:leave="transition duration-200"
                                            x-transition:leave-start="opacity-100 translate-x-0"
                                            x-transition:leave-end="opacity-0 -translate-x-4">
                                            <a href="{{ route('subcategorias', $subcat->id) }}"
                                                class="block px-2 py-1 text-xl text-[#4A4A4A] hover:text-[#AB8854] transition-colors">{{ $subcat->titulo }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <template x-if="subcats.filter(s => open && s.categoria_id === open).length">
                <div class="w-full lg:w-3/4 grid grid-cols-1 lg:grid-cols-3 gap-6 min-h-[200px]">
                    <template x-for="(subcat, i) in subcats.filter(s => open && s.categoria_id === open)"
                        :key="subcat.id">
                        <a :href="'/productos/' + subcat.id">
                            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100 + i * 100)" x-show="show"
                                x-transition:enter="transition duration-500"
                                x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition duration-300"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                                class="h-[432px] w-full relative flex flex-col group cursor-pointer">
                                <img :src="subcat.path" alt="coleccion imagen" class="w-full h-[329px] object-cover">
                                <div
                                    class="h-[329px] absolute inset-0 bg-black opacity-30 group-hover:opacity-10 transition-all duration-300">
                                </div>
                                <div class="py-5 flex flex-col items-center justify-center gap-2">
                                    <p class="text-[#898888]" x-text="subcat.categoria_titulo"></p>
                                    <p class="text-black text-2xl" x-text="subcat.titulo"></p>
                                </div>
                            </div>
                        </a>
                    </template </div>
            </template>
            <template x-if="!subcats.filter(s => open && s.categoria_id === open).length && open">
                <div class="w-3/4 flex items-center justify-center">
                    <div class="text-[#898888] text-xl w-full flex items-center justify-center py-10">No hay subcategorías
                        para esta categoría.</div>
                </div>
            </template>
            <template x-if="!open">
                <div class="w-3/4 flex items-center justify-center">
                    <div class="text-[#898888] text-xl w-full flex items-center justify-center py-10">Seleccioná una
                        categoría para ver sus subcategorías.</div>
                </div>
            </template>
        </div>
    </div>

@endsection
