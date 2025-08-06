<template>
  <div class="bg-gray-100 shadow-md flex justify-between items-center z-50 transition-all duration-300 hover:shadow-xl"
    style="height: 64px; padding: 0 2rem; border-bottom: 1px solid rgba(13, 129, 65, 0.1);">
    <div class="flex items-center">
      <button @click="toggleSidebar"
        class="text-gray-600 hover:text-gray-900 mr-3 cursor-pointer transition-all duration-200">
        <i class="fa-solid fa-bars"></i>
      </button>
      <h1 class="lg:text-lg font-semibold text-main-color">Panel de Administración</h1>
    </div>
    <div class="relative">
      <button class="flex items-center gap-2 rounded-full hover:bg-gray-100 transition-all duration-200"
        @click="toggleUserMenu" ref="userMenuButton">
        <span class="hidden sm:block text-gray-700 font-medium">{{ name.charAt(0).toUpperCase() + name.slice(1)
        }}</span>
        <i class="fa-sharp fa-solid fa-circle-user fa-xl transition-transform duration-300 text-main-color cursor-pointer"
          :class="{ 'rotate-180': isUserMenuOpen }"></i>
      </button>
      <div
        class="absolute right-0 mt-2 bg-white rounded-lg shadow-xl min-w-[220px] overflow-hidden z-[100] transition-all duration-300"
        :class="isUserMenuOpen ? 'opacity-100 visible translate-y-0' : 'opacity-0 invisible translate-y-2'"
        ref="userSubmenu">
        <div class="px-6 py-4 bg-main-color text-white">
          <p class="font-medium">{{ }}</p>
          <p class="text-xs opacity-75 truncate">{{ email }}</p>
        </div>
        <div class="py-2">
          <a :href="route('home')"
            class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
            <i class="fa-solid fa-home mr-3 text-main-color"></i>
            <span>Ir al inicio</span>
          </a>
          <button @click="logout"
            class="flex items-center w-full px-6 py-3 text-gray-700 hover:bg-gray-200 transition-colors duration-200">
            <i class="fa-solid fa-right-from-bracket mr-3 text-main-color"></i>
            <span>Cerrar Sesión</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { usePage, router } from '@inertiajs/vue3';

export default {
  props: {
    userName: {
      type: String,
      default: 'Usuario'
    },
    userEmail: {
      type: String,
      default: 'usuario@example.com'
    },
    title: {
      type: String,
      default: 'Panel de Administración'
    }
  },
  data() {
    return {
      isUserMenuOpen: false,
      userSubmenu: null,
      userMenuButton: null,
      name: usePage().props.auth.user.name,
      email: usePage().props.auth.user.email,
    };
  },
  methods: {
    toggleSidebar() {
      this.$emit('toggle-sidebar');
    },
    toggleUserMenu() {
      this.isUserMenuOpen = !this.isUserMenuOpen;
    }, logout() {
      router.post(route('logout'));
    },
    handleClickOutside(event) {
      if (
        this.isUserMenuOpen &&
        this.userSubmenu &&
        !this.userSubmenu.contains(event.target) &&
        this.userMenuButton &&
        !this.userMenuButton.contains(event.target)
      ) {
        this.isUserMenuOpen = false;
      }
    }
  },
  mounted() {
    document.addEventListener('click', this.handleClickOutside);
    console.log(usePage().props);
  },
  beforeDestroy() {
    document.removeEventListener('click', this.handleClickOutside);
  }
}
</script>