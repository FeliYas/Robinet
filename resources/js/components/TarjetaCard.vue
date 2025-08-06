<template>
  <div
    class="relative bg-white rounded-xl flex flex-col gap-6 items-center shadow-sm w-full mx-auto transition-all duration-300 h-[500px]">
    <div class="mb-4 absolute inset-0">
      <img v-if="tarjeta.path" :src="tarjeta.path" alt="icono" class=" h-[500px] w-full object-cover" />
      <slot name="icon" v-else />
    </div>
    <div class="absolute inset-0 bg-black opacity-30"></div>
    <transition name="card-fade-scale" mode="out-in" class="absolute bottom-0 flex items-center p-6">
      <div v-if="editando" key="edit" class="w-full flex flex-col flex-1">
        <input v-model="editTitulo"
          class="text-white border border-gray-200 rounded-lg px-2 py-1 w-full text-center text-2xl mb-2 transition-all duration-300" />
        <div class="flex gap-2 w-full mt-auto">
          <button @click="cancelarEdicion" class="btn-secondary flex-1">Cancelar</button>
          <button @click="guardarCambios" class="btn-primary flex-1">Guardar</button>
        </div>
      </div>
      <div v-else key="view" class="w-full flex flex-col flex-1 items-center">
        <img :src="tarjeta.icono" alt="icono">
        <h3 class="text-gray-200 text-2xl text-center py-2">{{ tarjeta.titulo }}</h3>
        <div class="w-full flex justify-center mt-auto">
          <button @click="editando = true" class="btn-secondary">
            Editar
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';

const notification = inject('noti');

const props = defineProps({
  tarjeta: {
    type: Object,
    required: true
  }
});

const editando = ref(false);
const editTitulo = ref(props.tarjeta.titulo);

watch(() => props.tarjeta, (n) => {
  editTitulo.value = n.titulo;
});

const guardarCambios = () => {
  const form = useForm({
    titulo: editTitulo.value,
  });
  form.put(route('tarjeta.update', props.tarjeta.id), {
    preserveScroll: true,
    onSuccess: (page) => {
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

const cancelarEdicion = () => {
  editTitulo.value = props.tarjeta.titulo;
  editando.value = false;
};
</script>

<style scoped>
/* Nueva transición más suave y moderna */
.card-fade-scale-enter-active,
.card-fade-scale-leave-active {
  transition: all 0.35s cubic-bezier(.4, 0, .2, 1);
  will-change: opacity, transform;
}

.card-fade-scale-enter-from,
.card-fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.96) translateY(20px);
}

.card-fade-scale-enter-to,
.card-fade-scale-leave-from {
  opacity: 1;
  transform: scale(1) translateY(0);
}
</style>
