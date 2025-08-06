<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['seccion', 'keyword', 'descripcion'];

// Definición de rutas
const updateRoute = (id) => route('metadatos.update', { id });
const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    metadatos: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Metadatos</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="metadatos" :updateRoute="updateRoute" />
    </div>
</template>
