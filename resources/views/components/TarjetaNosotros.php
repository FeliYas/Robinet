@props(['tarjeta'])

<div
    class="group relative bg-white rounded-xl flex flex-col gap-6 items-center shadow-sm w-full mx-auto transition-all duration-300 h-[500px] hover:shadow-2xl hover:-translate-y-2 hover:scale-105">
    <div class="mb-4 absolute inset-0">
        <img src="{{ $tarjeta->path }}" alt="icono" class=" h-[500px] w-full object-cover" />
        <slot name="icon" v-else />
    </div>
    <div class="absolute inset-0 bg-black opacity-30 group-hover:opacity-10 transition-all duration-300"></div>
    <div v-else key="view" class="absolute bottom-6 w-full flex flex-col flex-1 items-center">
        <img src="{{ $tarjeta->icono }}" alt="icono">
        <h3 class="text-gray-200 text-2xl text-center py-2">{{ $tarjeta->titulo }}</h3>
    </div>
</div>
