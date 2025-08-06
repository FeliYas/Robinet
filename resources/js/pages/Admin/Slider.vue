<script setup>
import { ref, inject } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DeleteModal from '@/components/Modales/DeleteModal.vue';
import CreateModal from '@/components/Modales/CreateModal.vue';
import EditModal from '@/components/Modales/EditModal.vue';

defineOptions({
  layout: DashboardLayout
});

// Inyectar el sistema de notificaciones global
const notification = inject('noti');

// Props
const props = defineProps({
  sliders: Array,
  logo: String
});

// States
const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const deletingSliderId = ref(null);
const isCreating = ref(false);
const isEditing = ref(false);
const isDeleting = ref(false);

// Refs
const fileInput = ref(null);

// Formulario de creación
const createForm = useForm({
  orden: '',
  titulo: '',
  descripcion: '',
  path: null
});

// Formulario de edición
const editForm = useForm({
  id: null,
  orden: '',
  titulo: '',
  descripcion: '',
  path: null
});

// Methods
const openCreateModal = () => {
  showCreateModal.value = true;
  createForm.fileLabel = 'Seleccionar archivo';
};

const closeCreateModal = () => {
  showCreateModal.value = false;
  resetCreateForm();
};

const resetCreateForm = () => {
  createForm.orden = '';
  createForm.titulo = '';
  createForm.path = null;
  createForm.fileLabel = 'Seleccionar archivo';
  createForm.filePreview = null;
  if (fileInput.value) fileInput.value.value = '';
};

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;

  createForm.path = file;
  createForm.fileLabel = file.name;

  // Vista previa para imágenes
  if (isImage(file.name)) {
    const reader = new FileReader();
    reader.onload = (e) => {
      createForm.filePreview = e.target.result;
    };
    reader.readAsDataURL(file);
  } else {
    createForm.filePreview = null;
  }
};

const submitCreateForm = () => {
  isCreating.value = true;
  createForm.post(route('slider.store'), {
    preserveScroll: true,
    onSuccess: () => {
      notification({ message: "Slider creado correctamente", type: "success" });
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

const openEditModal = (slider) => {
  editForm.id = slider.id;
  editForm.orden = slider.orden;
  editForm.titulo = slider.titulo;
  editForm.descripcion = slider.descripcion;
  editForm.currentPath = slider.path;
  editForm.path = null;
  editForm.fileLabel = 'Seleccionar nuevo archivo (opcional)';

  showEditModal.value = true;
};

const closeEditModal = () => {
  showEditModal.value = false;
};

const handleEditFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;

  editForm.path = file;
  editForm.fileLabel = file.name;
};

const submitEditForm = () => {
  isEditing.value = true;
  editForm.post(route('slider.update', editForm.id), {
    preserveScroll: true,
    onSuccess: () => {
      notification({ message: "Slider actualizado correctamente", type: "success" });
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

const openDeleteModal = (id) => {
  deletingSliderId.value = id;
  showDeleteModal.value = true;
};

const closeDeleteModal = () => {
  showDeleteModal.value = false;
  deletingSliderId.value = null;
};

const submitDeleteForm = () => {
  isDeleting.value = true;
  router.delete(route('slider.destroy', deletingSliderId.value), {
    onSuccess: () => {
      notification({ message: "Slider eliminado correctamente", type: "success" });
      closeDeleteModal();
    },
    onFinish: () => {
      isDeleting.value = false;
    }
  });
};

// Helper methods
const isImage = (path) => {
  const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
  const extension = getExtension(path);
  return imageExtensions.includes(extension.toLowerCase());
};

const isVideo = (path) => {
  const videoExtensions = ['mp4', 'webm', 'ogg'];
  const extension = getExtension(path);
  return videoExtensions.includes(extension.toLowerCase());
};

const getExtension = (path) => {
  return path.split('.').pop() || '';
};
</script>

<template>
  <div class="h-full">
    <div class="py-3 text-xl text-gray-700">
      <h1>Home Slider</h1>
    </div>
    <!-- Línea -->
    <hr class="border-t-[3px] border-main-color rounded">

    <!-- Mostrar Sliders existentes -->
    <div class="bg-gray-100 rounded-xl shadow-lg overflow-hidden mt-4 p-6">
      <div class="flex justify-start items-center mb-6 text-main-color">
        <!-- Botón Agregar -->
        <button class="btn-primary btn-icon-left" @click="openCreateModal">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
          Agregar
        </button>
      </div>

      <!-- Lista de sliders -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div v-for="slider in sliders" :key="slider.id"
          class="bg-gray-50 p-4 rounded-md border border-gray-200 flex flex-col justify-between">
          <!-- Imagen o Video -->
          <img v-if="isImage(slider.path)" :src="slider.path" :alt="slider.titulo"
            class="object-cover w-full h-[246px] border border-gray-300">
          <video v-else-if="isVideo(slider.path)" class="object-cover w-full h-[246px]" controls>
            <source :src="slider.path" :type="`video/${getExtension(slider.path)}`">
            Tu navegador no soporta el formato de video.
          </video>

          <div class="mt-2 flex-grow">
            <div class="flex flex-col items-start gap-2">
              <p class="text-gray-500">{{ slider.orden.toUpperCase() }}</p>
              <h3 class="text-2xl font-medium text-black">{{ slider.titulo }}</h3>
            </div>
          </div>

          <div class="flex gap-2 mt-2">
            <!-- Botones de acción -->
            <button type="button" @click="openEditModal(slider)"
              class="hover:bg-orange-100 p-2 rounded-full transition-all duration-200 cursor-pointer">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                  stroke="#f86903" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                  d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                  stroke="#f86903" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
            <button type="button" @click="openDeleteModal(slider.id)"
              class="text-red-600 hover:bg-red-100 p-2 rounded-full transition-all duration-200 cursor-pointer">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17"
                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <CreateModal v-if="showCreateModal" :show="showCreateModal" :columns="['orden', 'titulo', 'descripcion', 'path']"
      :categorias="[]" :formData="createForm" :fileInputLabel="createForm.fileLabel || 'Seleccionar archivo'"
      :fichaInputLabel="'No aplica'" :videoInputLabel="'No aplica'" :recomendacion="'1400x600'" :showPassword="false"
      :loading="isCreating" @close="closeCreateModal" @submit="submitCreateForm" @file-change="handleFileChange"
      @ficha-change="() => { }" @video-change="() => { }" @toggle-password="() => { }" />

    <EditModal v-if="showEditModal" :show="showEditModal" :columns="['orden', 'titulo', 'descripcion', 'path']"
      :categorias="[]" :formData="editForm"
      :fileInputLabel="editForm.fileLabel || 'Seleccionar nuevo archivo (opcional)'" :fichaInputLabel="'No aplica'"
      :videoInputLabel="'No aplica'" :imagePreview="editForm.currentPath" :videoPreview="null"
      :recomendacion="'1400x600'" :showPassword="false" :loading="isEditing" @close="closeEditModal"
      @submit="submitEditForm" @file-change="handleEditFileChange" @ficha-change="() => { }" @video-change="() => { }"
      @toggle-password="() => { }" @open-ficha="() => { }" />

    <DeleteModal v-if="showDeleteModal" :show="showDeleteModal" :loading="isDeleting" @close="closeDeleteModal"
      @confirm="submitDeleteForm" title="¿Estás seguro de que querés eliminar este slider?"
      message="Esta acción no se puede deshacer." />
  </div>
</template>