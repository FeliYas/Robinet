    <style>
        .cat-fade {
            opacity: 0;
            transform: translateY(24px) scale(0.98);
            transition: opacity 0.35s, transform 0.35s;
        }

        .cat-fade.cat-fade-in {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
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
            <div class="w-[90%] max-w-[1224px] mx-auto py-20 flex flex-col lg:flex-row gap-6 min-h-[80vh]"
                id="cat-accordion-root">
                <div class="w-full lg:w-1/4 flex flex-col text-[#4A4A4A] text-left border-t border-[#DCDCDC]"
                    id="cat-sidebar">
                    @php $firstId = $categorias->first()->id ?? null; @endphp
                    @foreach ($categorias as $categoria)
                        <div class="cat-accordion-item">
                            <button type="button"
                                class="w-full border-b border-[#DCDCDC] py-2 text-2xl font-bold text-left flex justify-between items-center focus:outline-none cat-accordion-btn"
                                data-cat-id="{{ $categoria->id }}">
                                <span class="cat-title">{{ $categoria->titulo }}</span>
                                <span class="cursor-pointer cat-arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12H19M12 5V19" stroke="#898888" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </button>
                            <div class="cat-accordion-panel border-b border-[#DCDCDC] cat-panel-trans"
                                data-cat-panel="{{ $categoria->id }}"
                                style="max-height:0;opacity:0;overflow:hidden;transition:max-height 0.5s cubic-bezier(.4,0,.2,1),opacity 0.4s;">
                                @if (isset($subcategorias[$categoria->id]))
                                    <ul class="flex flex-col">
                                        @foreach ($subcategorias[$categoria->id] as $subcat)
                                            <li>
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
                <div class="w-full lg:w-3/4 min-h-[200px]" id="cat-grid">
                    <div id="cat-grid-content">
                        <!-- JS will render subcategories here -->
                    </div>
                    <div id="cat-grid-empty" style="display:none;" class="w-full flex items-center justify-center">
                        <div class="text-[#898888] text-xl w-full flex items-center justify-center py-10">No hay
                            subcategorías
                            para esta categoría.</div>
                    </div>
                    <div id="cat-grid-select" style="display:none;" class="w-full flex items-center justify-center">
                        <div class="text-[#898888] text-xl w-full flex items-center justify-center py-10">Seleccioná una
                            categoría para ver sus subcategorías.</div>
                    </div>
                </div>
                @php
                    $subcatsData = collect($subcategorias)
                        ->map(function ($items) {
                            return $items->values();
                        })
                        ->values()
                        ->flatten(1)
                        ->map(function ($s) {
                            return [
                                'id' => $s->id,
                                'titulo' => $s->titulo,
                                'path' => $s->path,
                                'categoria_id' => $s->categoria_id,
                                'categoria_titulo' => optional($s->categoria)->titulo,
                            ];
                        })
                        ->values();
                @endphp
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const catSidebar = document.getElementById('cat-sidebar');
                        const catGridContent = document.getElementById('cat-grid-content');
                        const catGridEmpty = document.getElementById('cat-grid-empty');
                        const catGridSelect = document.getElementById('cat-grid-select');
                        const panels = document.querySelectorAll('.cat-accordion-panel');
                        const btns = document.querySelectorAll('.cat-accordion-btn');
                        let openId = {{ $firstId ?? 'null' }};
                        const subcats = @json($subcatsData);

                        function renderGrid(catId) {
                            // Fade out
                            catGridContent.classList.remove('cat-fade-in');
                            catGridContent.classList.add('cat-fade');
                            setTimeout(() => {
                                catGridContent.innerHTML = '';
                                if (!catId) {
                                    catGridContent.style.display = 'none';
                                    catGridEmpty.style.display = 'none';
                                    catGridSelect.style.display = 'flex';
                                    return;
                                }
                                const filtered = subcats.filter(s => s.categoria_id == catId);
                                if (!filtered.length) {
                                    catGridContent.style.display = 'none';
                                    catGridEmpty.style.display = 'flex';
                                    catGridSelect.style.display = 'none';
                                    return;
                                }
                                catGridContent.style.display = 'grid';
                                catGridContent.className = 'grid grid-cols-1 lg:grid-cols-3 gap-6 cat-fade';
                                catGridEmpty.style.display = 'none';
                                catGridSelect.style.display = 'none';
                                filtered.forEach(subcat => {
                                    const a = document.createElement('a');
                                    a.href = '/productos/' + subcat.id;
                                    a.innerHTML = `
                                    <div class="h-[432px] w-full relative flex flex-col group cursor-pointer">
                                        <img src="${subcat.path}" alt="coleccion imagen" class="w-full h-[329px] object-cover">
                                        <div class="h-[329px] absolute inset-0 bg-black opacity-30 group-hover:opacity-10 transition-all duration-300"></div>
                                        <div class="py-5 flex flex-col items-center justify-center gap-2">
                                            <p class="text-[#898888]">${subcat.categoria_titulo ?? ''}</p>
                                            <p class="text-black text-2xl">${subcat.titulo}</p>
                                        </div>
                                    </div>
                                `;
                                    catGridContent.appendChild(a);
                                });
                                // Fade in
                                setTimeout(() => {
                                    catGridContent.classList.add('cat-fade-in');
                                }, 10);
                            }, 200);
                        }

                        function openPanel(catId) {
                            panels.forEach(panel => {
                                if (panel.getAttribute('data-cat-panel') == catId) {
                                    panel.style.opacity = '1';
                                    panel.style.maxHeight = panel.scrollHeight + 'px';
                                } else {
                                    panel.style.opacity = '0';
                                    panel.style.maxHeight = '0';
                                }
                            });
                            btns.forEach(btn => {
                                if (btn.getAttribute('data-cat-id') == catId) {
                                    btn.classList.add('bg-gray-100');
                                    btn.querySelector('.cat-title').classList.add('text-black');
                                } else {
                                    btn.classList.remove('bg-gray-100');
                                    btn.querySelector('.cat-title').classList.remove('text-black');
                                }
                            });
                        }

                        btns.forEach(btn => {
                            btn.addEventListener('click', function() {
                                const catId = this.getAttribute('data-cat-id');
                                if (openId == catId) {
                                    openId = null;
                                    openPanel(null);
                                    renderGrid(null);
                                } else {
                                    openId = catId;
                                    openPanel(catId);
                                    renderGrid(catId);
                                }
                            });
                        });

                        // Inicializar con la primera categoría abierta
                        openPanel(openId);
                        renderGrid(openId);
                    });
                </script>
            </div>
        </div>

    @endsection
