<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

const notification = inject('noti');

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'titulo', 'activo'];

// Definición de rutas
const createRoute = route('categorias.store');
const updateRoute = (id) => route('categorias.update', { id });
const deleteRoute = (id) => route('categorias.destroy', { id });
const activoRoute = (id) => route('categorias.toggleActivo', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    categorias: {
        type: Array,
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

const bannerPreview = ref('');

// Set initial banner preview
onMounted(() => {
    bannerPreview.value = props.banner.banner;
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
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Categorias</h1>
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
                        alt="Banner preview" class="h-[500px] w-full object-cover rounded-lg">
                    <span class="text-sm text-gray-400 italic">Recomendación: 1400x500px</span>
                </div>
            </div>
            <div class="flex">
                <button type="submit" class="btn-primary flex w-full items-center" :disabled="form.processing">
                    {{ form.processing ? 'Actualizando...' : 'Actualizar banner' }}
                </button>
            </div>
        </form>
        <DataTable :columns="columns" :data="categorias" :createRoute="createRoute" :updateRoute="updateRoute"
            :deleteRoute="deleteRoute" :toggleActivoRoute="activoRoute"/>
    </div>
</template>
