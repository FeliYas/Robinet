
<script setup>
import { ref, onMounted } from 'vue';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

defineOptions({
    layout: DashboardLayout
});

const logo = ref(null);

onMounted(() => {
    // Add any mounted logic here if needed
});
</script>

<template>
  <div class="dashboard-page">
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
      <h1 class="text-2xl font-semibold text-gray-800">Dashboard Administrativo</h1>
      <p class="text-gray-600 mt-2">Bienvenido al panel de administración de su sitio web.</p>
    </div>
  </div>
</template>

