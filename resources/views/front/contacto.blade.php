@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Contacto'))

@section('content')
    <div>
        <div class="relative overflow-hidden text-[#DCDCDC] h-[300px] lg:h-[400px]">
            <img src="{{ $banner->banner }}" alt="{{ __('Banner de Contacto') }}"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute hidden lg:block inset-0 top-6 w-[90%] max-w-[1224px] mx-auto z-20">
                <div>
                    <div class="flex gap-1">
                        <a href="{{ route('home') }}" class="hover:underline">{{ __('Inicio') }}</a>
                        <span class="text-[#898888] text-lg">·</span>
                        <a href="{{ route('contacto') }}" class="text-[#898888] hover:underline">{{ __('Contacto') }}</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 w-[90%] max-w-[1224px] mx-auto flex items-center justify-center h-full">
                <div class="flex flex-col items-center text-center gap-1">
                    <p class="text-xl">Contacto</p>
                    <h2 class="text-[40px] font-bold text-white">Un puente hacia lo que imaginás</h2>
                </div>
            </div>
        </div>
        <div class="bg-[#1B1919] min-h-[120vh] lg:min-h-[60vh]">
            <div class="w-[90%] max-w-[1224px] mx-auto py-16 flex flex-col gap-10 lg:gap-12 text-[#DCDCDC]">
                <!-- Mensajes de feedback -->
                @if (session('success'))
                    <div id="successMessage"
                        class="fixed top-6 right-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 shadow-lg transition-opacity duration-500 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ __(session('success')) }}</span>
                        <button type="button" class="ml-auto" onclick="document.getElementById('successMessage').remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <script>
                        setTimeout(function() {
                            const message = document.getElementById('successMessage');
                            if (message) {
                                message.style.opacity = '0';
                                setTimeout(() => message.remove(), 500);
                            }
                        }, 5000);
                    </script>
                @endif
                @if (session('error'))
                    <div id="errorMessage"
                        class="fixed top-6 right-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg transition-opacity duration-500 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ __(session('error')) }}</span>
                        <button type="button" class="ml-auto" onclick="document.getElementById('errorMessage').remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <script>
                        setTimeout(function() {
                            const message = document.getElementById('errorMessage');
                            if (message) {
                                message.style.opacity = '0';
                                setTimeout(() => message.remove(), 500);
                            }
                        }, 5000);
                    </script>
                @endif
                @if ($errors->any())
                    <div id="validationErrors"
                        class="fixed top-6 right-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg transition-opacity duration-500">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-bold">{{ __('Por favor corrija los siguientes errores:') }}</span>
                            <button type="button" class="ml-auto"
                                onclick="document.getElementById('validationErrors').remove()">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ __($error) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <script>
                        setTimeout(function() {
                            const message = document.getElementById('validationErrors');
                            if (message) {
                                message.style.opacity = '0';
                                setTimeout(() => message.remove(), 500);
                            }
                        }, 7000);
                    </script>
                @endif
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-2/5 flex flex-col gap-1">
                        <h2 class="font-bold text-[32px]">Datos de contacto</h2>
                        <p class="text-xl mb-2">Estamos disponibles para cualquier necesidad
                        </p>
                        @foreach ($contactos as $contacto)
                            @if ($contacto->direccion)
                                <a href="https://maps.google.com/?q={{ urlencode($contacto->direccion) }}" target="_blank"
                                    class="py-1 hover:text-main-color flex gap-3 items-center underline text-[#898888]">
                                    <p class="max-w-1/2">
                                        {{ $contacto->direccion }}
                                    </p>
                                </a>
                            @endif
                            @if ($contacto->telefono)
                                <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono) }}"
                                    class="py-1 hover:text-main-color flex gap-3 items-center underline text-[#898888]">
                                    <p>
                                        {{ $contacto->telefono }}
                                    </p>
                                </a>
                            @endif
                            @if ($contacto->email)
                                <a href="mailto:{{ $contacto->email }}"
                                    class="py-1 hover:text-main-color flex gap-2 items-center underline text-[#898888]">
                                    <p>
                                        {{ $contacto->email }}
                                    </p>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <div class="lg:w-3/5">
                        <div class="flex flex-col gap-1">
                            <h2 class="font-bold text-[32px]">Datos de contacto</h2>
                            <p class="text-xl mb-2">Estamos disponibles para cualquier necesidad</p>
                            <p class="text-lg">Selecciona el área con la que necesitas contactarte</p>
                        </div>
                        <div x-data="{
                            open: false,
                            selected: '',
                            options: [
                                'Comercial',
                                'Repuestos y Servicio Técnico',
                                'Administración',
                                'Distribuidores'
                            ],
                            selectOption(option) {
                                this.selected = option;
                                this.open = false;
                                this.showForm();
                            },
                            showForm() {
                                if (this.selected) {
                                    // Actualizar el campo oculto con el área seleccionada
                                    document.getElementById('areaSeleccionada').value = this.selected;
                        
                                    // Mostrar el formulario con animación
                                    const form = document.getElementById('contactForm');
                                    form.classList.remove('hidden');
                                    form.style.opacity = '0';
                                    form.style.transform = 'translateY(20px)';
                        
                                    // Animar la aparición
                                    setTimeout(() => {
                                        form.style.transition = 'all 0.3s ease';
                                        form.style.opacity = '1';
                                        form.style.transform = 'translateY(0)';
                                    }, 10);
                                }
                            }
                        }" class="relative w-full py-10 mt-5 text-lg">
                            <button type="button" @click="open = !open"
                                class="border border-[#898888] w-full rounded-[30px] flex justify-between items-center px-6 py-3 bg-transparent text-[#DCDCDC] text-left">
                                <span x-text="selected ? selected : 'Seleccionar área'"></span>
                                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-200"
                                    fill="none" stroke="#DCDCDC" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute left-0 right-0 mt-2 bg-[#1B1919] border border-[#898888] rounded-[20px] shadow-lg z-30">
                                <template x-for="option in options" :key="option">
                                    <div @click="selectOption(option)"
                                        class="px-6 py-3 cursor-pointer hover:bg-[#232222] text-[#DCDCDC] rounded-[20px]">
                                        <span x-text="option"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- FORMULARIO OCULTO -->
                        <div id="contactForm" class="hidden">
                            <form action="{{ route('contacto.enviar') }}" method="POST"
                                class="w-full space-y-6 text-lg">
                                @csrf
                                <!-- Campo oculto para el área seleccionada -->
                                <input type="hidden" name="area_seleccionada" id="areaSeleccionada">

                                <div class="grid lg:grid-cols-2 gap-6">
                                    <div class="w-full relative">
                                        <label for="nombre"
                                            class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Nombre y apellido') }}*</label>
                                        <input type="text" name="nombre" id="nombre" required
                                            class="bg-transparent border border-[#898888] w-full h-12 px-4 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors">
                                    </div>
                                    <div class="w-full relative">
                                        <label for="telefono"
                                            class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Teléfono') }}*</label>
                                        <input type="text" name="telefono" id="telefono" required
                                            class="bg-transparent border border-[#898888] w-full h-12 px-4 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors">
                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-2 gap-6">
                                    <div class="w-full relative">
                                        <label for="provincia"
                                            class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Provincia') }}*</label>
                                        <input type="text" name="provincia" id="provincia" required
                                            class="bg-transparent border border-[#898888] w-full h-12 px-4 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors">
                                    </div>
                                    <div class="w-full relative">
                                        <label for="localidad"
                                            class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Localidad') }}*</label>
                                        <input type="text" name="localidad" id="localidad" required
                                            class="bg-transparent border border-[#898888] w-full h-12 px-4 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors">
                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-2 gap-6">
                                    <div class="w-full relative">
                                        <label for="email"
                                            class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Email') }}*</label>
                                        <input type="email" name="email" id="email" required
                                            class="bg-transparent border border-[#898888] w-full h-12 px-4 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors">
                                    </div>
                                    <div class="w-full relative">
                                        <label for="empresa"
                                            class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Empresa') }} *</label>
                                        <input type="text" name="empresa" id="empresa" required
                                            class="bg-transparent border border-[#898888] w-full h-12 px-4 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors">
                                    </div>
                                </div>

                                <div class="w-full relative">
                                    <label for="mensaje"
                                        class="block mb-2 text-[#DCDCDC] font-medium">{{ __('Mensaje') }}*</label>
                                    <textarea name="mensaje" id="mensaje" rows="6" required
                                        class="bg-transparent border border-[#898888] w-full px-4 py-3 rounded-[25px] text-[#DCDCDC] placeholder-[#666] focus:border-[#DCDCDC] focus:outline-none transition-colors resize-none"></textarea>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span>*Campos obligatorios</span>
                                    <div class="flex flex-col items-center">
                                        <!-- Campo oculto para reCAPTCHA -->
                                        <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                                        <button type="button" id="submitBtn"
                                            class="flex w-[183px] py-2 px-5 bg-transparent border border-white rounded-3xl items-center text-center justify-center text-xl hover:border-[#AB8854] hover:text-[#AB8854] transition-colors duration-300">
                                            <span id="submitText">{{ __('Enviar') }}</span>
                                            <span id="loadingIndicator" class="hidden flex items-center justify-center">
                                                <svg class="animate-spin h-5 w-5 text-white mr-2"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                {{ __('Enviando...') }}
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LekxJsrAAAAAJ2DLDq4m6ihQZ87_FqH9Wd0at4H"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar evento al botón de envío
            const submitBtn = document.getElementById('submitBtn');
            if (submitBtn) {
                submitBtn.addEventListener('click', handleSubmit);
            }

            function handleSubmit(e) {
                e.preventDefault();

                // Mostrar indicador de carga
                const submitText = document.getElementById('submitText');
                const loadingIndicator = document.getElementById('loadingIndicator');
                const submitBtn = document.getElementById('submitBtn');

                // Desactivar el botón y mostrar el indicador de carga
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');

                // Activar reCAPTCHA
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LekxJsrAAAAAJ2DLDq4m6ihQZ87_FqH9Wd0at4H', {
                        action: 'submit_contact'
                    }).then(function(token) {
                        // Guardar el token en el campo oculto
                        document.getElementById('recaptchaResponse').value = token;

                        // Enviar el formulario
                        submitBtn.closest('form').submit();
                    }).catch(function(error) {
                        // Restaurar el botón en caso de error
                        submitBtn.disabled = false;
                        submitText.classList.remove('opacity-0');
                        loadingIndicator.classList.add('hidden');

                        console.error('Error de reCAPTCHA:', error);
                    });
                });
            }
        });
    </script>

    <style>
        /* Estilo para el placeholder */
        ::placeholder {
            color: #666 !important;
            opacity: 1;
        }

        /* Cuando el input está enfocado */
        input:focus::placeholder,
        textarea:focus::placeholder {
            opacity: 0.5;
        }

        /* Animación al enfocar los campos */
        input:focus,
        textarea:focus {
            border-color: #DCDCDC !important;
            box-shadow: 0 0 0 1px rgba(220, 220, 220, 0.2);
        }

        /* Estilo para los inputs con fondo transparente */
        input[type="text"],
        input[type="email"],
        textarea {
            background-color: transparent !important;
        }
    </style>
@endsection
