<script setup>
import { inject } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

const notification = inject('noti');

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'path', 'titulo', 'categoria_id', 'destacado', 'activo'];

// Definición de rutas
const createRoute = route('subcategorias.store');
const updateRoute = (id) => route('subcategorias.update', { id });
const deleteRoute = (id) => route('subcategorias.destroy', { id });
const activoRoute = (id) => route('subcategorias.toggleActivo', { id });
const destacadoRoute = (id) => route('subcategorias.toggleDestacado', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    subcategorias: {
        type: Array,
        required: true
    },
    categorias: {
        type: Array,
        required: true
    },
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Subcategorias</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="subcategorias" :categorias="categorias" :createRoute="createRoute" :updateRoute="updateRoute"
            :deleteRoute="deleteRoute" recomendacion="320x300" :toggleActivoRoute="activoRoute" :toggleDestacadoRoute="destacadoRoute"/>
    </div>
</template>
