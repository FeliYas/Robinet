<script setup>
import { inject } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

const notification = inject('noti');

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'path', 'titulo', 'descripcion'];

// Definición de rutas
const createRoute = route('acabados.store');
const updateRoute = (id) => route('acabados.update', { id });
const deleteRoute = (id) => route('acabados.destroy', { id });
const destacadoRoute = (id) => route('acabados.toggleDestacado', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    acabados: {
        type: Array,
        required: true
    },
    colecciones: {
        type: Array,
        required: true
    },
});

</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Lista de Acabados</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="acabados" :agregados="colecciones" agregadosLabel="colecciones"
            :createRoute="createRoute" :updateRoute="updateRoute" :deleteRoute="deleteRoute"
            :toggleDestacadoRoute="destacadoRoute" recomendacion="240x240px" />
    </div>
</template>
