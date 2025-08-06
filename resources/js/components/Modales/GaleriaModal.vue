<script setup>
import { ref, watch, inject } from 'vue';
import { router } from '@inertiajs/vue3';
const notification = inject('noti');

const props = defineProps({
    show: Boolean,
    entityId: {
        type: [Number, String],
        required: true
    },
    entityType: {
        type: String, // 'producto' o 'proyecto'
        required: true
    },
    galeria: {
        type: Array,
        default: () => []
    },
    loading: Boolean
});

const emit = defineEmits(['close', 'refresh']);

const newImages = ref([]);
const ordenes = ref([]);
const uploading = ref(false);
const deleting = ref({});

watch(() => props.show, (val) => {
    if (!val) {
        newImages.value = [];
        ordenes.value = [];
    }
});

const handleFileChange = (event) => {
    newImages.value = Array.from(event.target.files);
    ordenes.value = newImages.value.map(() => '');
};

const handleOrdenChange = (idx, value) => {
    ordenes.value[idx] = value;
};

const handleUpload = async () => {
    if (!newImages.value.length) return;
    uploading.value = true;
    const formData = new FormData();
    newImages.value.forEach((file, idx) => {
        formData.append('imagenes[]', file);
        formData.append('ordenes[]', ordenes.value[idx] || '');
    });
    formData.append('entity_id', props.entityId);
    formData.append('entity_type', props.entityType);
    await router.post(route('galeria.update'), formData, {
        preserveScroll: true,
        onSuccess: (page) => {
            if (page.props && page.props.flash && page.props.flash.message) {
                notification && notification({ message: page.props.flash.message, type: 'success' });
            } else {
                notification && notification({ message: 'Imágen subida correctamente', type: 'success' });
            }
            emit('refresh');
            newImages.value = [];
            ordenes.value = [];
        },
        onError: (errors) => {
            notification && notification({ message: errors[0] || 'Error al subir imágenes', type: 'error' });
        },
        onFinish: () => {
            uploading.value = false;
        }
    });
};

const handleDelete = async (imgId) => {
    deleting.value[imgId] = true;
    await router.delete(route('galeria.destroy', imgId), {
        data: { entity_type: props.entityType },
        preserveScroll: true,
        onSuccess: (page) => {
            if (page.props && page.props.flash && page.props.flash.message) {
                notification && notification({ message: page.props.flash.message, type: 'success' });
            } else {
                notification && notification({ message: 'Imagen eliminada', type: 'success' });
            }
            emit('refresh');
        },
        onError: (errors) => {
            notification && notification({ message: errors[0] || 'Error al eliminar imagen', type: 'error' });
        },
        onFinish: () => { deleting.value[imgId] = false; }
    });
};
</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black opacity-20 backdrop-blur-sm" @click="!loading && $emit('close')">
            </div>
            <div class="relative w-full max-w-2xl z-50 bg-white rounded-lg shadow-lg max-h-[90vh]">
                <!-- Loading Overlay -->
                <div v-if="loading || uploading"
                    class="absolute inset-0 bg-white opacity-85 backdrop-blur-sm z-60 flex items-center justify-center rounded-lg">
                    <div class="flex flex-col items-center gap-4">
                        <div
                            class="animate-spin h-12 w-12 border-4 border-main-color border-t-transparent rounded-full">
                        </div>
                        <p class="text-black font-medium">Procesando...</p>
                    </div>
                </div>
                <div
                    class="bg-main-color bg-opacity-10 px-6 py-4 border-b border-main-color border-opacity-20 flex items-center justify-between rounded-t-lg">
                    <h2 class="text-white text-xl font-semibold flex items-center gap-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2" fill="none" />
                            <circle cx="9" cy="9" r="2" fill="#fff" />
                            <path d="M21 15L16 10L5 21" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        Galería
                    </h2>
                    <button type="button" @click="$emit('close')" :disabled="loading || uploading"
                        class="text-white hover:text-red-400 transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6M6 6l12 12" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 text-black max-h-[70vh] overflow-y-auto">
                    <div v-if="galeria && galeria.length">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <div v-for="img in [...galeria].sort((a, b) => (a.orden || '').localeCompare(b.orden || ''))"
                                :key="img.id" class="relative group">
                                <img :src="img.path"
                                    class="w-full h-40 object-cover rounded-lg border border-gray-200" />
                                <span
                                    class="absolute top-2 left-2 bg-main-color text-white text-xs px-2 py-0.5 rounded">Orden:
                                    {{ img.orden }}</span>
                                <button @click="handleDelete(img.id)" :disabled="deleting[img.id]"
                                    class="absolute top-2 right-2 bg-red-800 hover:bg-red-700 text-white rounded-full p-1 shadow cursor-pointer disabled:opacity-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-gray-700 mb-1">Agregar imágenes a la galería</label>
                        <input type="file" multiple accept="image/*" @change="handleFileChange"
                            class="block w-full border border-gray-300 rounded p-2 cursor-pointer"
                            :disabled="uploading" />
                    </div>
                    <div v-if="newImages.length">
                        <div v-for="(img, idx) in newImages" :key="img.name + idx" class="flex items-center gap-2 mb-2">
                            <span class="truncate max-w-xs">{{ img.name }}</span>
                            <input type="text" class="border rounded p-1 w-20 " placeholder="Orden"
                                v-model="ordenes[idx]" :disabled="uploading"
                                @input="e => handleOrdenChange(idx, e.target.value)" />
                        </div>
                        <button @click="handleUpload" class="btn-primary mt-2" :disabled="uploading">Subir
                            imágenes</button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
