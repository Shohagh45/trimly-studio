<template>
  <div class="app-wrapper">
    <Header v-if="showLayout" />
    <main class="main-content">
      <router-view />
    </main>
    <Footer v-if="showLayout" />
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { computed } from 'vue'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'

const route = useRoute()

// Hide layout on login and register pages
const showLayout = computed(() => !['/', '/register'].includes(route.path))
</script>

<style>

.app-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
}

html, body, #app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

#app > * {
  flex-grow: 1;
}

body::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: url('/background.jpg') no-repeat center center fixed;
  background-size: cover;
  opacity: 0.15; /* Adjust this between 0 (fully transparent) and 1 (fully visible) */
  z-index: -1;
  pointer-events: none;
}
</style>
