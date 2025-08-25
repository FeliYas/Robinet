<script setup>
import { ref, inject } from 'vue';
import { router } from '@inertiajs/vue3';
import DeleteModal from '@/components/Modales/DeleteModal.vue';
import CreateModal from '@/components/Modales/CreateModal.vue';
import EditModal from '@/components/Modales/EditModal.vue';
import GaleriaModal from '@/components/Modales/GaleriaModal.vue';
// Estado para la galería
const showGaleriaModal = ref(false);
const galeriaRow = ref(null);
const galeriaLoading = ref(false);
const galeriaData = ref([]);
const galeriaEntityType = ref('');

// Abrir la modal de galería
const openGaleriaModal = (row) => {
    galeriaRow.value = row;
    galeriaEntityType.value = props.entityType;
    galeriaLoading.value = true;
    // Si la galería ya viene en la row, úsala; si no, pedirla por AJAX (aquí solo ejemplo con row.galeria)
    if (row.galeria && Array.isArray(row.galeria)) {
        galeriaData.value = row.galeria;
        galeriaLoading.value = false;
        showGaleriaModal.value = true;
    } else {
        // Si necesitas pedirla por AJAX, aquí podrías hacer un fetch y luego abrir la modal
        galeriaData.value = [];
        galeriaLoading.value = false;
        showGaleriaModal.value = true;
    }
};

const refreshGaleria = () => {
    // Si tienes endpoint para refrescar la galería, puedes implementarlo aquí
    // Por ahora, solo cierra la modal y espera que la página se recargue por Inertia
    showGaleriaModal.value = false;
};

const props = defineProps({
    columns: Array,
    data: Array,
    categorias: Array,
    recomendacion: String,
    agregados: Array,
    agregadosLabel: String,

    // Rutas principales
    createRoute: {
        type: [String, Function],
        required: true
    },
    updateRoute: {
        type: Function,
        required: true
    },
    deleteRoute: {
        type: Function,
        required: true
    },

    // Rutas de toggles
    toggleDestacadoRoute: {
        type: Function,
        required: true
    },
    toggleActivoRoute: {
        type: Function,
        required: true
    },
    toggleAutorizadoRoute: {
        type: Function,
        required: true
    },

    entityType: {
        type: String,
        required: false,
    },
});

// Inyectar el sistema de notificaciones global
const notification = inject('noti');

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const showPassword = ref(false);
const showEditPassword = ref(false);
const currentItemId = ref(null);
const editFormData = ref({});
const createFormData = ref({});
const fileInputLabel = ref('Elija una imagen');
const editFileInputLabel = ref('Elija una nueva imagen');
const hoverInputLabel = ref('Elija una imagen hover');
const editHoverInputLabel = ref('Elija una nueva imagen hover');
const portadaInputLabel = ref('Elija una portada');
const editPortadaInputLabel = ref('Elija una nueva portada');
const iconoInputLabel = ref('Elija un icono');
const editIconoInputLabel = ref('Elija un nuevo icono');
const manualInputLabel = ref('Elija un Manual');
const editManualInputLabel = ref('Elija un nuevo Manual');
const autocadInputLabel = ref('Elija un Autocad');
const editAutocadInputLabel = ref('Elija un nuevo Autocad');
const recomendacion = props.recomendacion;
const agregadosLabel = props.agregadosLabel;
const isCreating = ref(false);
const isEditing = ref(false);
const isDeleting = ref(false);

// Para la vista previa de imágenes
const editImagePreview = ref('');
const editHoverPreview = ref('');
const editPortadaPreview = ref('');
const editIconoPreview = ref('');



const openCreateModal = () => {
    // Reset form data
    createFormData.value = {};
    props.columns.forEach(column => {
        if (column !== 'id' && column !== 'destacado' && column !== 'autorizado' && column !== 'activo') {
            createFormData.value[column] = '';
        }
        if (column === 'role') {
            createFormData.value[column] = 'user'; //
        }
    });
    showPassword.value = false;
    showCreateModal.value = true;
};
const closeCreateModal = () => {
    showCreateModal.value = false;
};
const openEditModal = (item) => {
    editFormData.value = { ...item };

    // Usar directamente el label como nombre de la relación (ya normalizado)
    const relationName = props.agregadosLabel || 'colecciones';

    if (item[relationName] && Array.isArray(item[relationName]) && props.agregados && Array.isArray(props.agregados)) {
        editFormData.value.agregados = item[relationName]
            .map(c => props.agregados.find(a => a.id === c.id))
            .filter(Boolean);
    } else {
        editFormData.value.agregados = [];
    }

    // Si hay una imagen, configurar la vista previa
    if (item.path) {
        editImagePreview.value = item.path;
    } else {
        editImagePreview.value = '';
    }
    if (item.hover) {
        editHoverPreview.value = item.hover;
    } else {
        editHoverPreview.value = '';
    }
    if (item.portada) {
        editPortadaPreview.value = item.portada;
    } else {
        editPortadaPreview.value = '';
    }
    if (item.icono) {
        editIconoPreview.value = item.icono;
    } else {
        editIconoPreview.value = '';
    }

    showEditPassword.value = false;
    showEditModal.value = true;
};
const closeEditModal = () => {
    showEditModal.value = false;
};
const openDeleteModal = (id) => {
    currentItemId.value = id;
    showDeleteModal.value = true;
};
const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
const toggleEditPasswordVisibility = () => {
    showEditPassword.value = !showEditPassword.value;
};

const handleCreateFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        fileInputLabel.value = file.name;
        createFormData.value.path = file;
    } else {
        fileInputLabel.value = 'Elija una imagen';
    }
};
const handleEditFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editFileInputLabel.value = file.name;
        editFormData.value.path = file;
    } else {
        editFileInputLabel.value = 'Elija una nueva imagen';
    }
};
const handleCreateManualChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        manualInputLabel.value = file.name;
        createFormData.value.manual = file;
    } else {
        manualInputLabel.value = 'Elija un Manual';
    }
};
const handleEditManualChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editManualInputLabel.value = file.name;
        editFormData.value.manual = file;
    } else {
        editManualInputLabel.value = 'Elija un nuevo Manual';
    }
};
const handleCreateAutocadChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        autocadInputLabel.value = file.name;
        createFormData.value.autocad = file;
    } else {
        autocadInputLabel.value = 'Elija un Autocad';
    }
};
const handleEditAutocadChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editAutocadInputLabel.value = file.name;
        editFormData.value.autocad = file;
    } else {
        editAutocadInputLabel.value = 'Elija uno nuevo Autocad';
    }
};
const handleCreateHoverChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        hoverInputLabel.value = file.name;
        createFormData.value.hover = file;
    } else {
        hoverInputLabel.value = 'Elija una imagen hover';
    }
};
const handleEditHoverChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editHoverInputLabel.value = file.name;
        editFormData.value.hover = file;
    } else {
        editHoverInputLabel.value = 'Elija una nueva imagen hover';
    }
};
const handleCreatePortadaChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        portadaInputLabel.value = file.name;
        createFormData.value.portada = file;
    } else {
        portadaInputLabel.value = 'Elija un portada';
    }
};
const handleEditPortadaChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editPortadaInputLabel.value = file.name;
        editFormData.value.portada = file;
    } else {
        editPortadaInputLabel.value = 'Elija un nuevo portada';
    }
};
const handleCreateIconoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        iconoInputLabel.value = file.name;
        createFormData.value.icono = file;
    } else {
        iconoInputLabel.value = 'Elija un icono';
    }
};
const handleEditIconoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        editIconoInputLabel.value = file.name;
        editFormData.value.icono = file;
    } else {
        editIconoInputLabel.value = 'Elija un nuevo icono';
    }
};


const openManual = (manualPath) => {
    if (manualPath) {
        // Abrir en una nueva pestaña para descargar/ver el PDF
        window.open(manualPath, '_blank');
    }
};
const openAutocad = (autocadPath) => {
    if (autocadPath) {
        // Abrir en una nueva pestaña para descargar/ver el PDF
        window.open(autocadPath, '_blank');
    }
};
const getCategoriaName = (categoriaId, row) => {
    // Si recibimos el objeto row y tiene una relación categoria con un título, usamos esa directamente
    if (row && row.categoria && row.categoria.titulo) {
        return row.categoria.titulo.charAt(0).toUpperCase() + row.categoria.titulo.slice(1);
    }

    // Si recibimos el objeto row y tiene una relación subcategoria con un título, usamos esa directamente
    if (row && row.subcategoria && row.subcategoria.titulo) {
        return row.subcategoria.titulo.charAt(0).toUpperCase() + row.subcategoria.titulo.slice(1);
    }

    // Como respaldo, buscamos en el array de categorías (comportamiento anterior)
    if (!props.categorias || !categoriaId) return 'N/A';
    const categoria = props.categorias.find(cat => cat.id === categoriaId);
    return categoria ? categoria.titulo.charAt(0).toUpperCase() + categoria.titulo.slice(1) : 'N/A';
};

const submitCreateForm = () => {
    isCreating.value = true;
    // Crear FormData para enviar archivos
    const formData = new FormData();

    Object.keys(createFormData.value).forEach(key => {
        if (key === 'agregados' && Array.isArray(createFormData.value.agregados)) {
            // Si es array de objetos, extraer los ids
            const ids = createFormData.value.agregados.map(a => a.id ? a.id : a);
            formData.append('agregados', ids.join(','));
        } else {
            formData.append(key, createFormData.value[key]);
        }
    });

    // Usar la ruta, que puede ser una string o una función
    const createUrl = typeof props.createRoute === 'function' ? props.createRoute() : props.createRoute;

    router.post(createUrl, formData, {
        onSuccess: (page) => {
            // Accede al mensaje flash de la respuesta
            if (page.props.flash && page.props.flash.message) {
                notification({ message: page.props.flash.message, type: "success" });
            } else {
                notification({ message: "Creado correctamente", type: "success" });
            }
            closeCreateModal();
        },
        onError: (errors) => {
            notification({ message: errors[0], type: "error" });
        },
        onFinish: () => {
            isCreating.value = false;
        }
    });
};
const submitEditForm = () => {
    isEditing.value = true;
    const formData = new FormData();

    Object.keys(editFormData.value).forEach(key => {
        if (key !== 'id') {
            if (key === 'agregados') {
                let ids = [];
                if (Array.isArray(editFormData.value.agregados)) {
                    ids = editFormData.value.agregados.map(a => a && typeof a === 'object' && a.id ? a.id : a).filter(Boolean);
                }
                formData.append('agregados', ids.join(','));
                return;
            }
            if (key === 'path' && typeof editFormData.value[key] === 'string') {
                return;
            }
            if (key === 'hover' && typeof editFormData.value[key] === 'string') {
                return;
            }
            if (key === 'portada' && typeof editFormData.value[key] === 'string') {
                return;
            }
            if (key === 'icono' && typeof editFormData.value[key] === 'string') {
                return;
            }
            if (key === 'manual' && (typeof editFormData.value[key] === 'string' || editFormData.value[key] === null || editFormData.value[key] === undefined)) {
                return;
            }
            if (key === 'autocad' && (typeof editFormData.value[key] === 'string' || editFormData.value[key] === null || editFormData.value[key] === undefined)) {
                return;
            }
            formData.append(key, editFormData.value[key]);
        }
    });

    formData.append('_method', 'PUT');

    // Usar directamente la función updateRoute
    const updateUrl = props.updateRoute(editFormData.value.id);

    router.post(updateUrl, formData, {
        onSuccess: (page) => {
            // Accede al mensaje flash de la respuesta
            if (page.props.flash && page.props.flash.message) {
                notification({ message: page.props.flash.message, type: "success" });
            } else {
                notification({ message: "Actualizado correctamente", type: "success" });
            }
            closeEditModal();
        },
        onError: (errors) => {
            notification({ message: errors[0], type: "error" });
        },
        onFinish: () => {
            isEditing.value = false;
        }
    });
};
const submitDeleteForm = () => {
    isDeleting.value = true;
    // Usar directamente la función deleteRoute
    const deleteUrl = props.deleteRoute(currentItemId.value);

    router.delete(deleteUrl, {
        onSuccess: (page) => {
            // Accede al mensaje flash de la respuesta
            if (page.props.flash && page.props.flash.message) {
                notification({ message: page.props.flash.message, type: "success" });
            } else {
                notification({ message: "Eliminado correctamente", type: "success" });
            }
            closeDeleteModal();
        },
        onFinish: () => {
            isDeleting.value = false;
        }
    });
};

// Update optimista para switches
const toggleSwitch = (id, key, isChecked, toggleRoute, labelSuccess, labelError) => {
    // 1. Update optimista en el array data
    const row = props.data.find(r => r.id === id);
    if (!row) return;
    const prev = row[key];
    row[key] = isChecked ? 1 : 0;

    // 2. Hacer la request
    const toggleUrl = toggleRoute(id);
    router.post(toggleUrl, {
        id: id,
        [key]: isChecked ? 1 : 0
    }, {
        preserveScroll: true,
        preserveState: false,
        onSuccess: (page) => {
            notification({ message: (page.props.flash && page.props.flash.message) || labelSuccess, type: "success" });
        },
        onError: () => {
            // Revertir si hay error
            row[key] = prev;
            notification({ message: labelError, type: "error" });
        }
    });
};

const toggleDestacado = (id, isChecked) => {
    toggleSwitch(id, 'destacado', isChecked, props.toggleDestacadoRoute, 'Destacado actualizado', 'Error al actualizar el destacado');
};
const toggleActivo = (id, isChecked) => {
    toggleSwitch(id, 'activo', isChecked, props.toggleActivoRoute, 'Activo actualizado', 'Error al actualizar el activo');
};
const toggleAutorizado = (id, isChecked) => {
    toggleSwitch(id, 'autorizado', isChecked, props.toggleAutorizadoRoute, 'Autorizado actualizado', 'Error al actualizar el autorizado');
};
</script>

<template>
    <div class="py-4">
        <div v-if="createRoute || aggProdRoute" class="flex justify-start items-center mb-6 gap-3">
            <button v-if="createRoute" class="btn-primary flex items-center gap-2" @click="openCreateModal">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Agregar
            </button>
        </div>

        <div class="grid-table-container">

            <!-- Encabezado de la grid -->
            <div class="grid-header">
                <template v-for="column in columns" :key="column">
                    <div v-if="column !== 'password' && column !== 'descripcion' && column !== 'lugar' && column !== 'icono' && column !== 'sitio_web' && column !== 'latitud' && column !== 'longitud' && column !== 'hover' && column !== 'codigo' && column !== 'manual' && column !== 'autocad'"
                        class="grid-header-cell">
                        <template v-if="column === 'categoria_id'">
                            Categoria
                        </template>
                        <template v-else-if="column === 'subcategoria_id'">
                            Subcategoria
                        </template>
                        <template v-else-if="column === 'path'">
                            Imagen
                        </template>
                        <template v-else>
                            {{ column.charAt(0).toUpperCase() + column.slice(1) }}
                        </template>
                    </div>
                </template>
                <div class="grid-header-cell">
                    Acciones
                </div>
            </div>

            <!-- Contenido de la grid -->
            <div class="grid-body">

                <!-- Mensaje cuando no hay datos -->
                <div v-if="!data || data.length === 0" class="grid-no-data">
                    No hay datos disponibles
                </div>

                <!-- Filas de datos -->
                <template v-else>
                    <div v-for="row in data" :key="row.id" class="grid-row">
                        <template v-for="column in columns" :key="column">
                            <div v-if="column !== 'password' && column !== 'descripcion' && column !== 'lugar' && column !== 'icono' && column !== 'sitio_web' && column !== 'latitud' && column !== 'longitud' && column !== 'hover' && column !== 'codigo' && column !== 'manual' && column !== 'autocad'"
                                :class="'grid-cell'">
                                <!-- Celda de imagen -->
                                <template v-if="column === 'path'">
                                    <img v-if="row.path" :src="row.path" alt="Imagen del producto"
                                        class="w-full flex items-center justify-center h-25 object-contain">
                                    <div v-else class="grid-no-image">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </template>
                                <template v-else-if="column === 'portada'">
                                    <img v-if="row.portada" :src="row.portada" alt="Imagen del producto"
                                        class="w-full flex items-center justify-center h-25 object-contain">
                                    <div v-else class="grid-no-image">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </template>
                                <!-- Destacado toggle -->
                                <template v-else-if="column === 'destacado'">
                                    <div class="grid-cell">
                                        <div class="flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" :checked="row.destacado"
                                                    @change="toggleDestacado(row.id, $event.target.checked)">
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#374977]">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                                <template v-else-if="column === 'activo'">
                                    <div class="grid-cell">
                                        <div class="flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" :checked="row.activo"
                                                    @change="toggleActivo(row.id, $event.target.checked)">
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#374977]">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                                <template v-else-if="column === 'autorizado'">
                                    <div class="grid-cell">
                                        <div class="flex justify-center">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer" :checked="row.autorizado"
                                                    @change="toggleAutorizado(row.id, $event.target.checked)">
                                                <div
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#374977]">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                                <template v-else-if="column === 'categoria_id'">
                                    {{ getCategoriaName(row[column], row) }}
                                </template>
                                <template v-else-if="column === 'subcategoria_id'">
                                    {{ getCategoriaName(row[column], row) }}
                                </template>
                                <template v-else>
                                    {{ row[column] ? row[column].charAt(0).toUpperCase() + row[column].slice(1) : '' }}
                                </template>
                            </div>
                        </template>

                        <!-- Celda de acciones -->
                        <div class="grid-cell grid-actions-cell">
                            <div class="grid-actions">
                                <button v-if="entityType" class="action-button view-button"
                                    @click="openGaleriaModal(row)">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" stroke="#1e3a8a"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="9" cy="9" r="2" stroke="#1e3a8a" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M21 15L16 10L5 21" stroke="#1e3a8a" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <!-- Modal de Galería (dinámica) -->
                                <GaleriaModal v-if="showGaleriaModal" :show="showGaleriaModal"
                                    :entityId="galeriaRow?.id" :entityType="galeriaEntityType" :galeria="galeriaData"
                                    :loading="galeriaLoading" @close="showGaleriaModal = false"
                                    @refresh="refreshGaleria" />
                                <button v-if="colocacionRoute" @click="router.get(colocacionRoute(row.id))"
                                    class="action-button list-button">
                                    <i class="fa-solid fa-list-ol text-2xl mt-1 text-green-700"></i>
                                </button>
                                <button v-if="updateRoute" @click="openEditModal(row)"
                                    class="action-button edit-button">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                                            stroke="#f86903" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                                            stroke="#f86903" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <button v-if="deleteRoute" @click="openDeleteModal(row.id)"
                                    class="action-button delete-button">
                                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <!-- Modal de Crear (componente) -->
        <CreateModal v-if="showCreateModal" :show="showCreateModal" :columns="columns" :categorias="categorias"
            :formData="createFormData" :fileInputLabel="fileInputLabel" :hoverInputLabel="hoverInputLabel"
            :portadaInputLabel="portadaInputLabel" :iconoInputLabel="iconoInputLabel"
            :manualInputLabel="manualInputLabel" :autocadInputLabel="autocadInputLabel" :recomendacion="recomendacion"
            :agregadosLabel="agregadosLabel" :agregados="agregados" :showPassword="showPassword" :loading="isCreating"
            @close="closeCreateModal" @submit="submitCreateForm" @file-change="handleCreateFileChange"
            @hover-change="handleCreateHoverChange" @portada-change="handleCreatePortadaChange"
            @icono-change="handleCreateIconoChange" @manual-change="handleCreateManualChange"
            @autocad-change="handleCreateAutocadChange" @toggle-password="togglePasswordVisibility" />

        <!-- Modal de Editar (componente) -->
        <EditModal v-if="showEditModal" :show="showEditModal" :columns="columns" :categorias="categorias"
            :formData="editFormData" :fileInputLabel="editFileInputLabel" :hoverInputLabel="editHoverInputLabel"
            :portadaInputLabel="editPortadaInputLabel" :iconoInputLabel="editIconoInputLabel"
            :manualInputLabel="editManualInputLabel" :autocadInputLabel="editAutocadInputLabel"
            :imagePreview="editImagePreview" :hoverPreview="editHoverPreview" :portadaPreview="editPortadaPreview"
            :iconoPreview="editIconoPreview" :recomendacion="recomendacion" :agregadosLabel="agregadosLabel"
            :agregados="agregados" :selectedAgregados="selectedAgregados" :showPassword="showEditPassword"
            :loading="isEditing" @close="closeEditModal" @submit="submitEditForm" @file-change="handleEditFileChange"
            @hover-change="handleEditHoverChange" @portada-change="handleEditPortadaChange"
            @icono-change="handleEditIconoChange" @manual-change="handleEditManualChange"
            @autocad-change="handleEditAutocadChange" @toggle-password="toggleEditPasswordVisibility"
            @open-manual="openManual" @open-autocad="openAutocad" />
        <!-- Componente Modal de Eliminación -->
        <DeleteModal v-if="showDeleteModal" :show="showDeleteModal" :loading="isDeleting" @close="closeDeleteModal"
            @confirm="submitDeleteForm" title="¿Estás seguro de que querés eliminar este elemento?"
            message="Esta acción no se puede deshacer." />


    </div>
</template>

<style scoped>
/* Estilos para la tabla grid */
.grid-table-container {
    width: 100%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

/* Estilos para el encabezado */
.grid-header {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    background-color: rgb(229, 231, 235);
    /* bg-gray-200 */
    border-bottom: 1px solid #e2e8f0;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.75rem;
    color: var(--main-color, #333);
    letter-spacing: 0.05em;
}

.grid-header-cell {
    padding: 1rem 1.5rem;
    text-align: center;
}

/* Estilos para el cuerpo de la tabla */
.grid-body {
    background-color: rgb(243, 244, 246);
    /* bg-gray-100 */
}

/* Mensaje cuando no hay datos */
.grid-no-data {
    padding: 1rem;
    text-align: center;
    grid-column: 1 / -1;
    color: rgb(55, 65, 81);
    /* text-gray-700 */
    font-size: 0.875rem;
}

/* Filas de datos */
.grid-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    align-items: center;
    transition: background-color 0.2s;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.grid-row:hover {
    background-color: rgb(229, 231, 235);
    /* hover:bg-gray-200 */
}

.grid-row:last-child {
    border-bottom: none;
}

/* Celdas */
.grid-cell {
    padding: 1rem 1.5rem;
    text-align: center;
    font-size: 0.875rem;
    color: rgb(55, 65, 81);
    /* text-gray-700 */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    align-items: center;
}

/* Mostrar el título completo, permitiendo varias líneas y sin cortar */
.show-full-title {
    white-space: normal !important;
    overflow: visible !important;
    text-overflow: unset !important;
    display: block;
    word-break: break-word;
    text-align: center;
    /* Opcional: puedes ajustar el ancho máximo si quieres limitarlo */
    /* max-width: 350px; */
}

.grid-no-image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    color: rgb(156, 163, 175);
    /* text-gray-400 */
}

/* Celda de acciones */
.grid-actions-cell {
    padding: 0.5rem;
}

.grid-actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.action-button {
    padding: 0.5rem;
    border-radius: 9999px;
    transition: all 0.2s;
    cursor: pointer;
    background-color: transparent;
    border: none;
}

.list-button:hover {
    background-color: rgba(34, 255, 0, 0.204);
    /* hover:bg-orange-100 */
}

.view-button:hover {
    background-color: rgba(15, 3, 248, 0.1);
    /* hover:bg-orange-100 */
}

.edit-button:hover {
    background-color: rgba(248, 105, 3, 0.1);
    /* hover:bg-orange-100 */
}

.delete-button {
    color: rgb(220, 38, 38);
    /* text-red-600 */
}

.delete-button:hover {
    background-color: rgba(248, 3, 3, 0.1);
    /* hover:bg-red-100 */
}

/* Ajuste para pantallas pequeñas */
@media (max-width: 768px) {
    .grid-header {
        display: none;
    }

    .grid-row {
        display: grid;
        grid-template-columns: 1fr;
        padding: 1rem 0;
        gap: 0.5rem;
        position: relative;
    }

    .grid-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .grid-cell:before {
        content: attr(data-label);
        font-weight: 600;
        margin-right: 0.5rem;
    }

    .grid-actions-cell {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding-top: 0.75rem;
    }
}

/* Animaciones para modales */
.modal-enter-active,
.modal-leave-active {
    transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
    transform: scale(0.95);
}
</style>