<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import QuillEditor from '@/components/QuillEditor.vue';
import TarjetaCard from '@/components/TarjetaCard.vue';

defineOptions({
    layout: DashboardLayout
});

// Inyectar el sistema de notificaciones global
const notification = inject('noti');

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    banner: {
        type: String,
        required: true
    },
    nosotros: {
        type: Object,
        required: true
    },
    tarjetas: {
        type: Array,
        required: true
    }
});

const imagePreview = ref('');
const bannerPreview = ref('');

// Initialize the form with nosotros data
const form = useForm({
    titulo: props.nosotros.titulo,
    descripcion: props.nosotros.descripcion,
    path: null,
    banner: null
});

// Set initial previews
onMounted(() => {
    imagePreview.value = props.nosotros.path;
    bannerPreview.value = props.banner.banner;
});

// Preview the selected image
const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.path = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        form.path = null;
        imagePreview.value = props.nosotros.path;
    }
};

// Preview the selected banner image
const previewBanner = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.banner = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            bannerPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        form.banner = null;
        bannerPreview.value = props.banner.banner;
    }
};


// Submit the form for update
const submit = () => {
    form.post(route('nosotros.update', props.nosotros.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            // Accede al mensaje flash de la respuesta
            if (page.props.flash && page.props.flash.message) {
                notification({ message: page.props.flash.message, type: "success" });
            } else {
                notification({ message: "Actualizado correctamente", type: "success" });
            }
        },
        onError: (errors) => {
            console.log(errors);
            notification({ message: errors[0], type: "error" });
        },
    });
};
</script>

<template>
    <div class="group relative h-full">
        <div class="py-3 text-xl text-gray-700">
            <h1>Nosotros</h1>
        </div>
        <hr class="border-t-[3px] border-main-color transition-all duration-500 ease-in-out opacity-70 rounded">

        <div class="w-full flex flex-col py-4 text-black">
            <form @submit.prevent="submit"
                class="w-full transition-all duration-300 hover:shadow-lg hover:border-main-color transform hover:-translate-y-1">
                <div
                    class="w-full bg-gray-100 p-6 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col gap-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="md:w-1/2 w-full flex flex-col justify-center">
                            <h3
                                class="block text-base font-semibold text-gray-700 mb-2 group-hover:text-main-color transition-colors duration-300">
                                Banner
                            </h3>
                            <div
                                class="relative overflow-hidden rounded-lg border-2 border-gray-200 group-hover:border-main-color transition-all duration-300 mb-2 w-full">
                                <img v-if="bannerPreview" :src="bannerPreview" alt="Banner preview"
                                    class="w-full h-32 md:h-80 object-cover rounded-md transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 flex items-center justify-center transition-all duration-300 opacity-0 hover:bg-opacity-20 hover:opacity-100">
                                    <label for="banner"
                                        class="cursor-pointer bg-white bg-opacity-80 text-main-color py-2 px-4 rounded-full flex items-center transform transition-transform duration-300 hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Cambiar banner
                                    </label>
                                </div>
                            </div>
                            <span class="text-sm text-gray-400 italic">Recomendación: 1400x500px</span>
                            <input type="file" class="hidden" id="banner" @change="previewBanner" accept="image/*">
                        </div>
                        <div class="md:w-1/2 w-full flex flex-col justify-center">
                            <h3
                                class="block text-base font-semibold text-gray-700 mb-2 group-hover:text-main-color transition-colors duration-300">
                                Imagen principal
                            </h3>
                            <div
                                class="relative overflow-hidden rounded-lg border-2 border-gray-200 group-hover:border-main-color transition-all duration-300 mb-2 w-full">
                                <img :src="imagePreview" alt="Imagen"
                                    class="w-full h-64 md:h-80 object-cover rounded-md transition-all duration-500">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 flex items-center justify-center transition-all duration-300 opacity-0 hover:bg-opacity-20 hover:opacity-100">
                                    <label for="path"
                                        class="cursor-pointer bg-white bg-opacity-80 text-main-color py-2 px-4 rounded-full flex items-center transform transition-transform duration-300 hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Cambiar imagen
                                    </label>
                                </div>
                            </div>
                            <span class="text-sm text-gray-400 italic">Recomendación: 600x600 px</span>
                            <input type="file" class="hidden" id="path" @change="previewImage">
                        </div>
                    </div>

                    <!-- Fila 2: Textos -->
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="w-full flex flex-col gap-4 justify-center">
                            <div class="relative group w-full">
                                <label for="titulo"
                                    class="block font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Título</label>
                                <input type="text" id="titulo" v-model="form.titulo"
                                    class="p-2 bg-white block border border-gray-300 w-full rounded-lg shadow-sm transition-all duration-200 focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20"
                                    required>
                            </div>
                            <div class="w-full">
                                <label for="descripcion"
                                    class="block font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Descripción</label>
                                <QuillEditor unique_ref="descripcion_editor" placeholder="Descripción"
                                    :initial_content="form.descripcion" v-on:text_changed="form.descripcion = $event" />
                            </div>

                        </div>
                    </div>

                    <!-- Botón -->
                    <div class="w-full flex mt-2">
                        <button type="submit" class="btn-primary w-full flex justify-center"
                            :disabled="form.processing">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ form.processing ? 'Actualizando...' : 'Actualizar nosotros' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex flex-col md:flex-row gap-6 items-center mt-6 bg-gray-100 py-8 px-30 rounded-xl">
            <template v-for="tarjeta in tarjetas" :key="tarjeta.id">
                <TarjetaCard :tarjeta="tarjeta" />
            </template>
        </div>
    </div>
</template>