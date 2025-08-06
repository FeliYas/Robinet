<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import QuillEditor from '@/components/QuillEditor.vue';

const notification = inject('noti');

defineOptions({
    layout: DashboardLayout
});


const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    contenido: {
        type: Object,
        required: true
    },
    banner: {
        type: String,
        required: true
    }
});
const form = useForm({
    banner: null // This will hold the file object
});
const formContenido = useForm({
    titulo: props.contenido.titulo || '',
    descripcion: props.contenido.descripcion || '',
    path: null // This will hold the file object
});

const bannerPreview = ref('');
const imagePreview = ref('');

// Set initial banner preview
onMounted(() => {
    bannerPreview.value = props.banner.banner;
    imagePreview.value = props.contenido.path;
});

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
    }
};

// Funciones específicas para cada preview
const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        formContenido.path = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Submit the form for update
const submit = () => {
    form.post(route('banner.update', props.banner.id), {
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
// Funciones específicas de submit para cada formulario
const submitContenido = () => {
    formContenido.post(route('acabadoscontenido.update', props.contenido.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            if (page.props.flash && page.props.flash.message) {
                notification({ message: page.props.flash.message, type: "success" });
            } else {
                notification({ message: "Contenido de acabados actualizado correctamente", type: "success" });
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
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Contenido de Acabados</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <form @submit.prevent="submit" class="my-6 p-6 text-black bg-gray-200 rounded-2xl">
            <div class="relative group md:col-span-2">
                <div
                    class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="mt-0.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="9" cy="9" r="2"></circle>
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                    </svg>
                </div>
                <label for="banner"
                    class="block font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Banner</label>
                <input type="file" id="banner" @input="previewBanner" accept="image/*"
                    class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200">

                <!-- Vista previa del banner -->
                <div v-if="bannerPreview" class="mt-4">
                    <img :src="bannerPreview.startsWith('blob:') || bannerPreview.startsWith('data:') ? bannerPreview : `${bannerPreview}`"
                        alt="Banner preview" class="h-[400px] w-full object-cover object-bottom rounded-lg" />
                    <span class="text-sm text-gray-400 italic">Recomendación: 1400x500px</span>
                </div>
            </div>
            <div class="flex">
                <button type="submit" class="btn-primary flex w-full items-center" :disabled="form.processing">
                    {{ form.processing ? 'Actualizando...' : 'Actualizar banner' }}
                </button>
            </div>
        </form>
        <div class="w-full flex flex-col gap-8 py-4">
            <form @submit.prevent="submitContenido"
                class="w-full transition-all duration-300 hover:shadow-lg hover:border-main-color transform hover:-translate-y-1">
                <div
                    class="w-full bg-gray-100 p-6 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Contenedor de la imagen con vista previa -->
                        <div class="md:w-1/3 flex flex-col">
                            <h3
                                class="block font-medium text-gray-700 mb-2 group-hover:text-main-color transition-colors duration-300">
                                Imagen principal</h3>
                            <div
                                class="relative overflow-hidden rounded-lg border-2 border-gray-200 group-hover:border-main-color transition-all duration-300">
                                <img :src="imagePreview" alt="Imagen"
                                    class="w-full h-auto object-cover rounded-md transition-all duration-500">

                                <!-- Overlay con efecto al hover -->
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

                            <!-- Recomendación de tamaño -->
                            <span class="text-sm text-gray-400 mt-2 italic">Recomendación: 600x600 px</span>

                            <!-- Input file oculto -->
                            <input type="file" class="hidden" id="path" @change="previewImage">
                        </div>

                        <!-- Contenedor de formulario -->
                        <div class="flex flex-col justify-between w-full md:w-2/3 text-black">
                            <div class="flex flex-col gap-4">
                                <div class="relative group w-full">
                                    <label for="titulo"
                                        class="block font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Título</label>
                                    <input type="text" id="titulo" v-model="formContenido.titulo"
                                        class="p-2 bg-white block border border-gray-300 w-full rounded-lg shadow-sm transition-all duration-200 focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20"
                                        required>
                                </div>
                                <div class="w-full">
                                    <label for="descripcion"
                                        class="block font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Descripción</label>
                                    <QuillEditor unique_ref="descripcion_editor" placeholder="Descripción"
                                        :initial_content="formContenido.descripcion"
                                        v-on:text_changed="formContenido.descripcion = $event">
                                    </QuillEditor>
                                </div>
                            </div>

                            <!-- Botón de actualizar -->
                            <div class="mb-6.5 mt-4">
                                <button type="submit" class="btn-primary w-full flex items-center justify-center"
                                    :disabled="formContenido.processing">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    {{ formContenido.processing ? 'Actualizando...' : 'Actualizar contenido' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
