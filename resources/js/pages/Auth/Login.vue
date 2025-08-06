<script setup>
import { Head } from '@inertiajs/vue3'
</script>
<template>

  <Head>
    <title>Login</title>
  </Head>
  <div class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div id="particles-js" class="fixed inset-0 z-0"></div>
    <div class="z-10">
      <a :href="route('home')"
        class="back-link flex absolute top-4 left-4 px-4 text-black py-2 outline-none hover:underline hidden lg:block">
        <i class="fa-solid fa-arrow-left mr-2 p-1" style="color: #1B1919;"></i>Volver al Home
      </a>
      <div>
        <div class="flex justify-center p-6 mb-6">
          <img :src="logo.path" :alt="logo.seccion"
            class="h-20 md:h-25 transition-transform duration-300 hover:scale-105">
        </div>
        <div class="bg-white shadow-2xl shadow-[#292b2a] rounded-lg p-8 max-w-lg lg:w-[500px] login-card"
          :class="{ 'error-animation': form.hasErrors }">
          <form @submit.prevent="submit">
            <div>
              <h2 class="mb-2 text-lg font-medium text-gray-800">Ingresar</h2>
              <hr class="mb-5 border-t-[2px] border-main-color w-16 transition-all duration-300"
                :class="{ 'w-full': hoverTitle }" @mouseover="hoverTitle = true" @mouseleave="hoverTitle = false">
            </div>

            <div v-if="form.hasErrors"
              class="mb-4 p-4 rounded-md bg-red-50 border-l-4 border-red-400 text-red-600 shadow-sm">
              <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">{{ form.errors && (form.errors.login || form.errors.password ||
                  'Credenciales incorrectas') }}</p>
              </div>
            </div>

            <div class="mb-5 form-input-container">
              <label class="block text-gray-700 mb-2 font-medium">Usuario o Correo electrónico</label>
              <input type="text" v-model="form.login"
                class="input-focus-effect text-black rounded-md w-full px-4 py-3 border border-main-color focus:border-main-color focus:ring focus:ring-main-color/25 focus:ring-opacity-50 outline-none"
                required>
            </div>

            <div class="mb-5 form-input-container">
              <label class="block text-gray-700 mb-2 font-medium">Contraseña</label>
              <input type="password" v-model="form.password"
                class="input-focus-effect text-black rounded-md w-full px-4 py-3 border border-main-color focus:border-main-color focus:ring focus:ring-main-color/25 focus:ring-opacity-50 outline-none"
                required>
            </div>

            <div class="flex items-center mb-6">
              <input type="checkbox" id="remember" v-model="form.remember" class="remember-checkbox mr-2 w-4 h-4">
              <label for="remember" class="text-gray-700 select-none cursor-pointer">Recuérdame</label>
            </div>

            <button type="submit" class="btn-primary w-full flex items-center justify-center py-3 font-medium"
              :disabled="form.processing">
              <span v-if="!form.processing">Iniciar Sesión</span>
              <span v-else class="spinner-container">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-main-color" xmlns="http://www.w3.org/2000/svg"
                  fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="black" stroke-width="4"></circle>
                  <path class="opacity-75" fill="black"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                <span>Verificando...</span>
              </span>
            </button>
          </form>
        </div>
        <div class="flex justify-between text-gray-500 text-xs lg:text-sm mt-6 font-semibold">
          <span>© 2025 Robinet</span>
          <span>by Osole</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    logo: {
      type: Object,
      default: () => ({
        path: 'default-logo.png',
        seccion: 'Robinet'
      })
    }
  },

  data() {
    return {
      hoverTitle: false,
      form: {
        login: '',
        password: '',
        remember: false,
        processing: false,
        hasErrors: false,
        errors: {}
      }
    };
  },

  methods: {
    submit() {
      this.form.processing = true;
      this.$inertia.post(route('login'), {
        login: this.form.login,
        password: this.form.password,
        remember: this.form.remember
      }, {
        onError: (errors) => {
          this.form.hasErrors = true;
          this.form.errors = errors;
          this.form.processing = false;
        },
        onSuccess: () => {
          this.form.processing = false;
        }
      });
    }
  },

  mounted() {
    this.$nextTick(() => {
      window.addEventListener('load', () => {
        this.initParticles();
      });

      this.initParticles();
    });
  },

  methods: {
    submit() {
      this.form.processing = true;

      // Si estás usando Inertia.js

      this.$inertia.post(route('login'), {
        login: this.form.login,
        password: this.form.password,
        remember: this.form.remember
      }, {
        onError: (errors) => {
          this.form.hasErrors = true;
          this.form.errors = errors;
          this.form.processing = false;
        },
        onSuccess: () => {
          this.form.processing = false;
        }
      });
    },

    initParticles() {
      if (window.particlesJS) {
        try {
          window.particlesJS('particles-js', {
            "particles": {
              "number": {
                "value": 100,
                "density": {
                  "enable": true,
                  "value_area": 900
                }
              },
              "color": {
                "value": "#AB8854"
              },
              "shape": {
                "type": "circle",
                "stroke": {
                  "width": 0,
                  "color": "#AB8854"
                },
                "polygon": {
                  "nb_sides": 5
                }
              },
              "opacity": {
                "value": 0.4,
                "random": true,
                "anim": {
                  "enable": true,
                  "speed": 0.5,
                  "opacity_min": 0.1,
                  "sync": false
                }
              },
              "size": {
                "value": 3,
                "random": true,
                "anim": {
                  "enable": true,
                  "speed": 2,
                  "size_min": 0.1,
                  "sync": false
                }
              },
              "line_linked": {
                "enable": true,
                "distance": 160,
                "color": "#AB8854",
                "opacity": 0.3,
                "width": 1
              },
              "move": {
                "enable": true,
                "speed": 1.2,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                  "enable": true,
                  "rotateX": 600,
                  "rotateY": 1200
                }
              }
            },
            "interactivity": {
              "detect_on": "canvas",
              "events": {
                "onhover": {
                  "enable": true,
                  "mode": "grab"
                },
                "onclick": {
                  "enable": true,
                  "mode": "push"
                },
                "resize": true
              },
              "modes": {
                "grab": {
                  "distance": 140,
                  "line_linked": {
                    "opacity": 0.8
                  }
                },
                "bubble": {
                  "distance": 400,
                  "size": 40,
                  "duration": 2,
                  "opacity": 8,
                  "speed": 3
                },
                "repulse": {
                  "distance": 200,
                  "duration": 0.4
                },
                "push": {
                  "particles_nb": 4
                },
                "remove": {
                  "particles_nb": 2
                }
              }
            },
            "retina_detect": true
          });
        } catch (e) {
          console.error("Error al inicializar particles.js:", e);
        }
      } else {
        console.warn("particles.js no está cargado");
      }
    }
  }
}
</script>

<style scoped>
/* Estilos adicionales para modernizar manteniendo la estructura */
.login-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  position: relative;
  z-index: 10;
  /* Asegurar que esté por encima del fondo de partículas */
}

.login-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.back-link {
  transition: transform 0.2s ease;
  z-index: 10;
  /* Asegurar que esté por encima del fondo de partículas */
}

.back-link:hover {
  transform: translateX(-3px);
}

/* Asegurar que los inputs sean interactivos */
input {
  z-index: 20;
  /* Asegurar que estén por encima de todo */
  position: relative;
  /* Para que el z-index funcione */
  background-color: #fff;
  /* Fondo blanco para evitar transparencia */
}

.input-focus-effect:focus {
  transform: scale(1.01);
  border-width: 2px;
}

/* Estilo para mensajes de error */
.error-animation {
  animation: shake 0.5s ease-in-out;
}

@keyframes shake {

  0%,
  100% {
    transform: translateX(0);
  }

  25% {
    transform: translateX(-8px);
  }

  75% {
    transform: translateX(8px);
  }
}

/* Mejora para el spinner */
.spinner-container {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

/* Borde flotante para inputs */
.form-input-container {
  position: relative;
}

/* Efecto para el botón de recordar */
.remember-checkbox {
  cursor: pointer;
  transition: all 0.2s ease;
}

.remember-checkbox:checked {
  accent-color: #AB8854;
}


.btn-secondary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

</style>