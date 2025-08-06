<script setup>
import { watch } from 'vue';

// Props
const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: '¿Estás seguro de que querés eliminar este elemento?'
    },
    message: {
        type: String,
        default: 'Esta acción no se puede deshacer.'
    },
    confirmButtonText: {
        type: String,
        default: 'Eliminar'
    },
    cancelButtonText: {
        type: String,
        default: 'Cancelar'
    },
    loading: {
        type: Boolean,
        default: false
    }
});

// Emits
const emit = defineEmits(['close', 'confirm']);

// Methods
const closeModal = () => {
    emit('close');
};

const confirmDelete = () => {
    emit('confirm');
};
</script>

<template>
    <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-200 ease-in"
        leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <!-- Overlay con transición -->
            <Transition enter-active-class="transition-opacity duration-300" enter-from-class="opacity-0"
                enter-to-class="opacity-60" leave-active-class="transition-opacity duration-200"
                leave-from-class="opacity-60" leave-to-class="opacity-0">
                <div class="absolute inset-0 bg-black opacity-60 backdrop-blur-sm" @click="closeModal"></div>
            </Transition>
            <!-- Modal -->
            <div class="relative w-full max-w-md z-50 bg-white rounded-lg shadow-lg overflow-hidden">
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
                <div class="bg-white rounded-lg shadow-lg w-full overflow-hidden">
                    <!-- Header con icono de advertencia -->
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100 flex justify-center">
                        <div class="rounded-full bg-red-100 p-3 inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="p-6 text-center">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ title }}</h2>
                        <p class="text-gray-600">{{ message }}</p>
                    </div>

                    <!-- Footer con botones -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-center gap-3">
                        <button type="button" @click="closeModal" class="btn-secondary btn-icon-left">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ cancelButtonText }}
                        </button>
                        <button type="button" @click="confirmDelete" class="btn-primary" :disabled="loading">
                            <svg v-if="loading" class="animate-spin h-4 w-4 mr-2 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            {{ confirmButtonText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>