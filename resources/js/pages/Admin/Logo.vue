<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['seccion', 'path'];


// Definición de rutas
const updateRoute = (id) => route('logos.update', { id });
const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    logos: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Logos</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="logos" :updateRoute="updateRoute" recomendacion="174x92"/>
    </div>
</template>
