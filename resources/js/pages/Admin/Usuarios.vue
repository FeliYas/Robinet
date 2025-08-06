<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['name', 'email', 'role', 'password'];

// Definición de rutas
const createRoute = route('usuarios.store');
const updateRoute = (id) => route('usuarios.update', { id });
const deleteRoute = (id) => route('usuarios.destroy', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    usuarios: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Usuarios</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="usuarios" :deleteRoute="deleteRoute" :createRoute="createRoute" :updateRoute="updateRoute" />
    </div>
</template>
