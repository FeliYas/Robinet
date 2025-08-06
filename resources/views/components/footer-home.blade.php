@props(['logos', 'contactos', 'redes'])

<footer class="text-[#DCDCDC]">
    <div class="bg-black">
        <div
            class="grid grid-cols-1 lg:grid-cols-4 gap-10 lg:gap-6 justify-between w-[90%] xl:max-w-[1224px] mx-auto py-20">
            <div class="flex flex-col items-center md:items-center justify-center lg:justify-start gap-10 w-full lg:w-max">
                <img src="{{ asset($logos[0]->path) }}" alt="logo" class="object-contain h-[66px] ">
                <div class="flex items-center justify-center gap-4.5">
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
            <div class="text-center lg:text-left flex flex-col gap-9">
                <h3 class="font-bold text-2xl">{{ __('Secciones') }}</h3>
                <div class="flex flex-row md:pr-4 justify-center gap-6 md:gap-0 lg:justify-between items-center lg:items-left text-xl">
                    <div class="flex flex-col gap-y-2">
                        <a href="{{ route('nosotros') }}"
                            class="hover:text-[#AB8854] transition-colors duration-300">{{ __('Nosotros') }}</a>
                        <a href="{{ route('categorias') }}"
                            class="hover:text-[#AB8854] transition-colors duration-300">{{ __('Productos') }}</a>
                        <a href="{{ route('proyectos') }}"
                            class="hover:text-[#AB8854] transition-colors duration-300">{{ __('Proyectos') }}</a>
                    </div>
                    <div class="flex flex-col gap-y-2">
                        <a href="{{ route('acabados') }}"
                            class="hover:text-[#AB8854] transition-colors duration-300">{{ __('Acabados') }}</a>
                        <a href="{{ route('puntosventa') }}"
                            class="hover:text-[#AB8854] transition-colors duration-300">{{ __('Puntos de venta') }}</a>
                        <a href="{{ route('contacto') }}"
                            class="hover:text-[#AB8854] transition-colors duration-300">{{ __('Contacto') }}</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center lg:items-start text-center lg:text-start gap-9">
                <div>
                    <h3 class="font-bold text-2xl w-[260px]">{{ __('Suscribite al Newsletter') }}
                    </h3>
                </div>
                <form id="newsletterForm" class="w-full h-[45px] flex flex-col items-center">
                    @csrf
                    <div
                        class="w-[288px] h-[51px] border border-[#DCDCDC] rounded-[30px] flex justify-between placeholder:text-white">
                        <input type="email" name="email" placeholder="{{ __('Email') }}"
                            class="bg-transparent border-none outline-none p-3 w-full" required>
                        <button type="submit"
                            class="flex items-center justify-center rounded-r-[20px] px-3 cursor-pointer transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#DCDCDC" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div id="newsletterMessage" class="text-xs mt-2"></div>
                </form>
            </div>
            <div class="flex flex-col items-center gap-9">
                <div class="text-left w-full">
                    <h3 class="font-bold text-2xl text-center lg:text-left">{{ __('Datos de Contacto') }}
                    </h3>
                </div>
                <div
                    class="flex flex-col gap-4 items-center lg:items-start justify-center text-center lg:text-left text-xl">
                    @foreach ($contactos as $contacto)
                        @if ($contacto->direccion)
                            <a href="https://maps.google.com/?q={{ urlencode($contacto->direccion) }}" target="_blank"
                                class="block no-underline text-inherit hover:text-main-color transition-colors duration-300">
                                <div class="flex gap-3">
                                    <p class="hover:text-[#AB8854] transition-colors duration-300">
                                        {{ $contacto->direccion }}
                                    </p>
                                </div>
                            </a>
                        @endif
                        @if ($contacto->telefono)
                            <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono) }}"
                                class="block no-underline text-inherit hover:text-main-color transition-colors duration-300">
                                <div class="flex gap-3">
                                    <p class="hover:text-[#AB8854] transition-colors duration-300">
                                        {{ $contacto->telefono }}
                                    </p>
                                </div>
                            </a>
                        @endif
                        @if ($contacto->email)
                            <a href="mailto:{{ $contacto->email }}"
                                class="block no-underline text-inherit hover:text-main-color transition-colors duration-300">
                                <div class="flex gap-3">
                                    <p class="hover:text-[#AB8854] transition-colors duration-300">
                                        {{ $contacto->email }}
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row text-center lg:text-left justify-between gap-6 items-center w-[90%] max-w-[1224px] mx-auto py-3">
            <p>{{ __('© Copyright 2025 Robinet S.A. Todos los derechos reservados') }}</p>
            <p>{{ __('By') }}
                <a href="https://osole.com.ar/#" class="font-bold hover:text-[#AB8854] transition-colors duration-300">
                    Osole
                </a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('newsletterForm');
            const messageDiv = document.getElementById('newsletterMessage');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const email = this.querySelector('input[name="email"]').value;
                    messageDiv.innerHTML = '<span class="text-blue-300">{{ __('Enviando...') }}</span>';
                    axios.post('{{ route('newsletter.store') }}', {
                            email,
                            _token: token
                        })
                        .then(function() {
                            messageDiv.innerHTML =
                                '<span class="text-green-500">{{ __('Suscripción exitosa') }}</span>';
                            form.reset();
                            setTimeout(() => {
                                messageDiv.innerHTML = '';
                            }, 3000);
                        })
                        .catch(function(error) {
                            let msg = '<span class="text-red-500">';
                            if (error.response?.data?.message) msg += error.response.data.message;
                            else if (error.request) msg += 'No se recibió respuesta del servidor';
                            else msg += 'Error al enviar la solicitud';
                            msg += '</span>';
                            messageDiv.innerHTML = msg;
                            setTimeout(() => {
                                messageDiv.innerHTML = '';
                            }, 3000);
                        });
                });
            }
        });
    </script>
</footer>
