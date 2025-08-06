<script setup>
import QuillEditor from '@/components/QuillEditor.vue';
import Multiselect from 'vue-multiselect';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    show: Boolean,
    columns: Array,
    categorias: Array,
    formData: Object,
    fileInputLabel: String,
    manualInputLabel: String,
    autocadInputLabel: String,
    hoverInputLabel: String,
    portadaInputLabel: String,
    iconoInputLabel: String,
    imagePreview: String,
    hoverPreview: String,
    portadaPreview: String,
    iconoPreview: String,
    recomendacion: String,
    agregadosLabel: String,
    agregados: {
        type: Array,
        required: false,
        default: undefined
    },
    selectedAgregados: {
        type: Array,
        default: () => []
    },
    showPassword: Boolean,
    loading: Boolean,
});
const emit = defineEmits(['close', 'submit', 'file-change', 'manual-change', 'autocad-change', 'hover-change', 'portada-change', 'icono-change', 'toggle-password', 'open-manual', 'open-autocad']);

const page = usePage();
const currentRoute = computed(() => page.url || (page.props.ziggy && page.props.ziggy.location) || '');



const getExtension = (filename) => {
    if (!filename) return '';
    return filename.split('.').pop().toLowerCase();
};
const isImage = (filename) => {
    const exts = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
    return exts.includes(getExtension(filename));
};
const isVideo = (filename) => {
    const exts = ['mp4', 'webm', 'ogg', 'avi', 'mov'];
    return exts.includes(getExtension(filename));
};
</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black opacity-60 backdrop-blur-sm" @click="$emit('close')"></div>
            <div class="relative w-full max-w-2xl z-50 bg-white rounded-lg shadow-lg max-h-[90vh]">
                <!-- Loading Overlay -->
                <div v-if="loading"
                    class="absolute inset-0 bg-white opacity-85 backdrop-blur-sm z-60 flex items-center justify-center rounded-lg">
                    <div class="flex flex-col items-center gap-4">
                        <div
                            class="animate-spin h-12 w-12 border-4 border-main-color border-t-transparent rounded-full">
                        </div>
                        <p class="text-black font-medium">Procesando...</p>
                    </div>
                </div>
                <form @submit.prevent="$emit('submit')" enctype="multipart/form-data"
                    class="rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="bg-main-color bg-opacity-10 px-5 py-3 border-b border-main-color border-opacity-20">
                        <h2 class="text-white text-xl font-semibold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </h2>
                    </div>
                    <!-- Formulario -->
                    <div class="p-4 text-black max-h-[70vh] overflow-y-auto">
                        <div v-for="column in columns" :key="column" class="py-3">
                            <template v-if="column === 'destacado'"></template>
                            <template v-else-if="column === 'activo'"></template>
                            <template v-else-if="column === 'productos relacionados'"></template>
                            <template v-else-if="column === 'path'">
                                <template v-if="currentRoute.includes('/admin/home/slider')">
                                    <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">Imagen o
                                        video</label>
                                </template>
                                <template v-else>
                                    <label :for="`edit_${column}`"
                                        class="block font-medium text-gray-700 mb-1">Imagen</label>
                                </template>
                                <div class="relative w-full">
                                    <label :for="`edit_${column}`"
                                        class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                        {{ fileInputLabel }}
                                    </label>
                                    <input type="file" :id="`edit_${column}`" @change="$emit('file-change', $event)"
                                        class="hidden">
                                    <p class="text-xs text-gray-400 mt-1">
                                        <template v-if="currentRoute.includes('/admin/home/slider')">
                                            Formatos permitidos: JPEG, PNG, JPG, GIF, SVG, MP4, AVI, MOV, WEBP,
                                            WEBM.<br>
                                            Recomendacion: {{ recomendacion }}px
                                        </template>
                                        <template v-else>
                                            Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                            Recomendacion: {{ recomendacion }}px
                                        </template>
                                    </p>
                                </div>
                                <div v-if="imagePreview" class="mt-2">
                                    <p class="block text-gray-700">Imagen actual:</p>
                                    <img v-if="isImage(imagePreview)" :src="imagePreview" alt="Imagen actual"
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2">
                                    <video v-else-if="isVideo(imagePreview)" :src="imagePreview" controls
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2"></video>
                                    <span v-else class="text-gray-500">No se puede mostrar vista previa</span>
                                </div>
                            </template>
                            <template v-else-if="column === 'hover'">
                                <label :for="`edit_${column}`"
                                    class="block font-medium text-gray-700 mb-1">Hover</label>

                                <div class="relative w-full">
                                    <label :for="`edit_${column}`"
                                        class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                        {{ hoverInputLabel }}
                                    </label>
                                    <input type="file" :id="`edit_${column}`" @change="$emit('hover-change', $event)"
                                        class="hidden">
                                    <p class="text-xs text-gray-400 mt-1">
                                        Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                        Recomendacion: 1400x500px
                                    </p>
                                </div>
                                <div v-if="hoverPreview" class="mt-2">
                                    <p class="block text-gray-700">Hover actual:</p>
                                    <img v-if="isImage(hoverPreview)" :src="hoverPreview" alt="Imagen actual"
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2">
                                    <video v-else-if="isVideo(hoverPreview)" :src="hoverPreview" controls
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2"></video>
                                    <span v-else class="text-gray-500">No se puede mostrar vista previa</span>
                                </div>
                            </template>
                            <template v-else-if="column === 'portada'">
                                <label :for="`edit_${column}`"
                                    class="block font-medium text-gray-700 mb-1">Portada</label>

                                <div class="relative w-full">
                                    <label :for="`edit_${column}`"
                                        class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                        {{ portadaInputLabel }}
                                    </label>
                                    <input type="file" :id="`edit_${column}`" @change="$emit('portada-change', $event)"
                                        class="hidden">
                                    <p class="text-xs text-gray-400 mt-1">
                                        Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                        Recomendacion: 1400x500px
                                    </p>
                                </div>
                                <div v-if="portadaPreview" class="mt-2">
                                    <p class="block text-gray-700">Portada actual:</p>
                                    <img v-if="isImage(portadaPreview)" :src="portadaPreview" alt="Imagen actual"
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2">
                                    <video v-else-if="isVideo(portadaPreview)" :src="portadaPreview" controls
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2"></video>
                                    <span v-else class="text-gray-500">No se puede mostrar vista previa</span>
                                </div>
                            </template>
                            <template v-else-if="column === 'icono'">
                                <label :for="`edit_${column}`"
                                    class="block font-medium text-gray-700 mb-1">Icono</label>

                                <div class="relative w-full">
                                    <label :for="`edit_${column}`"
                                        class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                        {{ iconoInputLabel }}
                                    </label>
                                    <input type="file" :id="`edit_${column}`" @change="$emit('icono-change', $event)"
                                        class="hidden">
                                    <p class="text-xs text-gray-400 mt-1">
                                        Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                        Recomendacion: 45x47px
                                    </p>
                                </div>
                                <div v-if="iconoPreview" class="mt-2">
                                    <p class="block text-gray-700">Icono actual:</p>
                                    <img v-if="isImage(iconoPreview)" :src="iconoPreview" alt="Imagen actual"
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2">
                                    <video v-else-if="isVideo(iconoPreview)" :src="iconoPreview" controls
                                        class="w-full h-40 object-contain border border-main-color rounded-md bg-gray-200 p-2"></video>
                                    <span v-else class="text-gray-500">No se puede mostrar vista previa</span>
                                </div>
                            </template>
                            <template v-else-if="column === 'manual'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">Manual
                                    (Opcional)</label>
                                <div class="relative w-full">
                                    <label :for="`edit_${column}`"
                                        class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                        {{ manualInputLabel }}
                                    </label>
                                    <input type="file" :id="`edit_${column}`" @change="$emit('manual-change', $event)"
                                        accept="application/pdf" class="hidden">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Formatos permitidos: .pdf .doc .docx - Máximo 5MB
                                </p>
                                <div v-if="formData.manual && typeof formData.manual === 'string'" class="mt-2">
                                    <p class="block text-gray-700">Manual actual:</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <button @click="$emit('open-manual', formData.manual)" type="button"
                                            class="text-blue-500 hover:underline text-sm">
                                            Ver manual actual
                                        </button>
                                    </div>
                                </div>
                                <hr class="mt-5 mx-8 border-gray-400">
                            </template>
                            <template v-else-if="column === 'autocad'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">Autocad
                                    (Opcional)</label>
                                <div class="relative w-full">
                                    <label :for="`edit_${column}`"
                                        class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                        {{ autocadInputLabel }}
                                    </label>
                                    <input type="file" :id="`edit_${column}`" @change="$emit('autocad-change', $event)"
                                        accept="application/pdf" class="hidden">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Formatos permitidos: .pdf .dwg .dxf - Máximo 15MB
                                </p>
                                <div v-if="formData.autocad && typeof formData.autocad === 'string'" class="mt-2">
                                    <p class="block text-gray-700">Autocad actual:</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <button @click="$emit('open-autocad', formData.autocad)" type="button"
                                            class="text-blue-500 hover:underline text-sm">
                                            Ver Autocad actual
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <template v-else-if="column === 'categoria_id'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    Categoria
                                </label>
                                <select :id="`edit_${column}`" v-model="formData[column]"
                                    class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color"
                                    required>
                                    <option value="" disabled>Seleccione una categoría</option>
                                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                        {{ categoria.titulo }}
                                    </option>
                                </select>
                            </template>
                            <template v-else-if="column === 'subcategoria_id'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    Subcategoria
                                </label>
                                <select :id="`edit_${column}`" v-model="formData[column]"
                                    class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color"
                                    required>
                                    <option value="" disabled>Seleccione una subcategoria</option>
                                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                        {{ categoria.titulo }}
                                    </option>
                                </select>
                            </template>
                            <template v-else-if="column === 'role'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    Rol
                                </label>
                                <select :id="`edit_${column}`" v-model="formData[column]"
                                    class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </template>
                            <template v-else-if="column === 'password'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    Contraseña <span class="text-gray-500">(Minimo 8 caracteres)</span>
                                </label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" :id="`edit_${column}`"
                                        v-model="formData[column]"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color pr-10"
                                        placeholder="Dejar vacío para mantener la contraseña actual">
                                    <button type="button"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 cursor-pointer"
                                        @click="$emit('toggle-password')">
                                        <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12C9 11.2044 9.31607 10.4413 9.87868 9.87868C10.4413 9.31607 11.2044 9 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C21.27 16.39 17 19.5 12 19.5C7 19.5 2.73 16.39 1 12C2.73 7.61 7 4.5 12 4.5ZM3.18 12C3.98825 13.6503 5.24331 15.0407 6.80248 16.0133C8.36165 16.9858 10.1624 17.5013 12 17.5013C13.8376 17.5013 15.6383 16.9858 17.1975 16.0133C18.7567 15.0407 20.0117 13.6503 20.82 12C20.0117 10.3497 18.7567 8.95925 17.1975 7.98675C15.6383 7.01424 13.8376 6.49868 12 6.49868C10.1624 6.49868 8.36165 7.01424 6.80248 7.98675C5.24331 8.95925 3.98825 10.3497 3.18 12Z"
                                                fill="black" />
                                        </svg>
                                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M2 5.27L3.28 4L20 20.72L18.73 22L15.65 18.92C14.5 19.3 13.28 19.5 12 19.5C7 19.5 2.73 16.39 1 12C1.69 10.24 2.79 8.69 4.19 7.46L2 5.27ZM12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15.0005 12.3406 14.943 12.6787 14.83 13L11 9.17C11.3213 9.05698 11.6594 8.99949 12 9ZM12 4.5C17 4.5 21.27 7.61 23 12C22.1834 14.0729 20.7966 15.8723 19 17.19L17.58 15.76C18.9629 14.8034 20.0783 13.5091 20.82 12C20.0117 10.3499 18.7565 8.95963 17.1974 7.98735C15.6382 7.01508 13.8375 6.49976 12 6.5C10.91 6.5 9.84 6.68 8.84 7L7.3 5.47C8.74 4.85 10.33 4.5 12 4.5ZM3.18 12C3.98835 13.6501 5.24346 15.0404 6.80264 16.0126C8.36182 16.9849 10.1625 17.5002 12 17.5C12.69 17.5 13.37 17.43 14 17.29L11.72 15C11.0242 14.9254 10.3748 14.6149 9.87997 14.12C9.38512 13.6252 9.07458 12.9758 9 12.28L5.6 8.87C4.61 9.72 3.78 10.78 3.18 12Z"
                                                fill="black" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <template v-else-if="column === 'descripcion'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    Descripcion
                                </label>
                                <QuillEditor :unique_ref="`edit_${column}`" placeholder="Descripcion"
                                    :initial_content="formData[column]" v-on:text_changed="formData[column] = $event" />
                            </template>
                            <template v-else-if="column === 'sitio_web'">
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    Sitio Web
                                </label>
                                <input :id="`edit_${column}`" v-model="formData[column]" type="text"
                                    class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color">
                            </template>
                            <template v-else>
                                <label :for="`edit_${column}`" class="block font-medium text-gray-700 mb-1">
                                    {{ column.charAt(0).toUpperCase() + column.slice(1) }}
                                </label>
                                <input :name="column" v-model="formData[column]" :id="`edit_${column}`" type="text"
                                    class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color">
                            </template>
                        </div>
                        <template v-if="agregados && agregados.length > 0">
                            <label class="block font-medium text-gray-700">
                                {{ agregadosLabel.charAt(0).toUpperCase() + agregadosLabel.slice(1) }} <span
                                    class="text-gray-500">(Opcional)</span>
                            </label>
                            <multiselect v-model="formData.agregados" :options="agregados" :multiple="true"
                                :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                :placeholder="`Seleccionar ${agregadosLabel}`" label="titulo" track-by="id"
                                class="mt-2 mb-4">
                                <template #option="{ option }">
                                    <div class="flex items-center gap-2">
                                        <img :src="option.path" alt="" class="w-8 h-8 object-cover rounded" />
                                        <span>{{ option.titulo }}</span>
                                    </div>
                                </template>
                            </multiselect>
                        </template>
                    </div>
                    <!-- Footer con botones -->
                    <div class="px-6 py-4 bg-gray-100 border-t border-gray-200 flex justify-end gap-3">
                        <button type="button" @click="$emit('close')"
                            class="btn-secondary px-4 py-2 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </button>
                        <button type="submit" class="btn-primary px-4 py-2 flex items-center gap-1" :disabled="loading">
                            <svg v-if="loading" class="animate-spin h-4 w-4 mr-2 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Transition>
</template>
