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
    hoverInputLabel: String,
    portadaInputLabel: String,
    iconoInputLabel: String,
    manualInputLabel: String,
    autocadInputLabel: String,
    recomendacion: String,
    agregadosLabel: String,
    agregados: {
        type: Array,
        required: false,
        default: undefined
    },
    showPassword: Boolean,
    loading: Boolean,
});

const emit = defineEmits(['close', 'submit', 'file-change', 'hover-change', 'portada-change', 'icono-change', 'manual-change', 'autocad-change', 'toggle-password']);


// Asegurarse que formData.agregados sea un array para el v-model de multiselect
if (props.formData && !Array.isArray(props.formData.agregados)) {
    props.formData.agregados = [];
}

const page = usePage();
const currentRoute = computed(() => page.url || (page.props.ziggy && page.props.ziggy.location) || '');

</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black opacity-60 backdrop-blur-sm" @click="!loading && $emit('close')">
            </div>
            <Transition name="modal-content">
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
                        <div class="bg-main-color bg-opacity-10 px-6 py-4 border-b border-main-color border-opacity-20">
                            <div class="flex items-center justify-between">
                                <h2 class="text-white text-xl font-semibold flex items-center gap-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Crear
                                </h2>
                                <button type="button" @click="$emit('close')" :disabled="loading"
                                    class="text-white hover:text-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Formulario -->
                        <div class="p-6 text-black max-h-[70vh] overflow-y-auto">
                            <div v-for="column in columns" :key="column" class="py-3">
                                <template v-if="column === 'destacado'"></template>
                                <template v-else-if="column === 'activo'"></template>
                                <template v-else-if="column === 'productos relacionados'"></template>
                                <template v-else-if="column === 'path'">
                                    <template v-if="currentRoute.includes('/admin/home/slider')">
                                        <label :for="column" class="block font-medium text-gray-700 mb-1">Imagen o
                                            video</label>
                                    </template>
                                    <template v-else>
                                        <label :for="column" class="block font-medium text-gray-700 mb-1">Imagen</label>
                                    </template>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center transition-colors"
                                            :class="{ 'cursor-not-allowed opacity-50': loading }">
                                            {{ fileInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('file-change', $event)"
                                            :disabled="loading" class="hidden">
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
                                </template>
                                <template v-else-if="column === 'hover'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Imagen hover</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center transition-colors"
                                            :class="{ 'cursor-not-allowed opacity-50': loading }">
                                            {{ hoverInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('hover-change', $event)"
                                            :disabled="loading" class="hidden">
                                        <p class="text-xs text-gray-400 mt-1">
                                            Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                            Recomendacion: 288x288px
                                        </p>
                                    </div>
                                </template>
                                <template v-else-if="column === 'portada'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Portada</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center transition-colors"
                                            :class="{ 'cursor-not-allowed opacity-50': loading }">
                                            {{ portadaInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('portada-change', $event)"
                                            :disabled="loading" class="hidden">
                                        <p class="text-xs text-gray-400 mt-1">
                                            Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                            Recomendacion: 1400x500px
                                        </p>
                                    </div>
                                </template>
                                <template v-else-if="column === 'icono'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Icono</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center transition-colors"
                                            :class="{ 'cursor-not-allowed opacity-50': loading }">
                                            {{ iconoInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('icono-change', $event)"
                                            :disabled="loading" class="hidden">
                                        <p class="text-xs text-gray-400 mt-1">
                                            Formatos permitidos: JPEG, PNG, JPG, SVG, WEBP.<br>
                                            Recomendacion: 45x47px
                                        </p>
                                    </div>
                                </template>
                                <template v-else-if="column === 'categoria_id'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Categoria
                                    </label>
                                    <select :id="column" v-model="formData[column]" :disabled="loading"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color disabled:opacity-50 disabled:cursor-not-allowed"
                                        required>
                                        <option value="" disabled>Seleccione una categoría</option>
                                        <option v-for="categoria in categorias" :key="categoria.id"
                                            :value="categoria.id">
                                            {{ categoria.titulo }}
                                        </option>
                                    </select>
                                </template>
                                <template v-else-if="column === 'subcategoria_id'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Subcategorias
                                    </label>
                                    <select :id="column" v-model="formData[column]" :disabled="loading"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color disabled:opacity-50 disabled:cursor-not-allowed"
                                        required>
                                        <option value="" disabled>Seleccione una subcategoría</option>
                                        <option v-for="categoria in categorias" :key="categoria.id"
                                            :value="categoria.id">
                                            {{ categoria.titulo }}
                                        </option>
                                    </select>
                                </template>
                                <template v-else-if="column === 'manual'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1 ">Manual (Opcional)</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center transition-colors"
                                            :class="{ 'cursor-not-allowed opacity-50': loading }">
                                            {{ manualInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('manual-change', $event)"
                                            accept="application/pdf" :disabled="loading" class="hidden">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Formatos permitidos: .pdf .doc .docx - Máximo 5MB</p>
                                </template>
                                <template v-else-if="column === 'autocad'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Autocad (Opcional)</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center transition-colors"
                                            :class="{ 'cursor-not-allowed opacity-50': loading }">
                                            {{ autocadInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('autocad-change', $event)"
                                            accept="application/pdf" :disabled="loading" class="hidden">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Formatos permitidos: .pdf .dwg .dxf - Máximo 15MB</p>
                                </template>
                                <template v-else-if="column === 'role'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Rol
                                    </label>
                                    <select :id="column" v-model="formData[column]" :disabled="loading"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color disabled:opacity-50 disabled:cursor-not-allowed"
                                        required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </template>
                                <template v-else-if="column === 'password'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Contraseña <span class="text-gray-500">(Minimo 8 caracteres)</span>
                                    </label>
                                    <div class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" :id="column"
                                            v-model="formData[column]" :disabled="loading"
                                            class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color pr-10 disabled:opacity-50 disabled:cursor-not-allowed"
                                            required>
                                        <button type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50"
                                            :disabled="loading" @click="$emit('toggle-password')">
                                            <!-- Iconos de ojo -->
                                            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268-2.943-9.543-7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template v-else-if="column === 'descripcion'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Descripcion
                                    </label>
                                    <div :class="{ 'pointer-events-none opacity-50': loading }">
                                        <QuillEditor :unique_ref="`create_${column}`" placeholder="Descripcion"
                                            :initial_content="formData[column]"
                                            v-on:text_changed="formData[column] = $event" />
                                    </div>
                                </template>
                                <template v-else-if="column === 'sitio_web'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Sitio Web
                                    </label>
                                    <input :id="column" :name="column" v-model="formData[column]" type="text"
                                        :disabled="loading"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color disabled:opacity-50 disabled:cursor-not-allowed"
                                        required>
                                </template>
                                <template v-else>
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        {{ column.charAt(0).toUpperCase() + column.slice(1) }}
                                    </label>
                                    <input :id="column" :name="column" v-model="formData[column]" type="text"
                                        :disabled="loading"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color disabled:opacity-50 disabled:cursor-not-allowed"
                                        required>
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
                                    class="mt-2 mb-4" :open-direction="'top'">
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
                            <button type="button" @click="$emit('close')" :disabled="loading"
                                class="btn-secondary px-4 py-2 flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </button>
                            <button type="submit"
                                class="btn-primary px-4 py-2 flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="loading">
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
                                {{ loading ? 'Procesando...' : 'Crear' }}
                            </button>
                        </div>
                    </form>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-content-enter-active,
.modal-content-leave-active {
    transition: all 0.3s ease;
}

.modal-content-enter-from,
.modal-content-leave-to {
    opacity: 0;
    transform: scale(0.9) translateY(-10px);
}
</style>