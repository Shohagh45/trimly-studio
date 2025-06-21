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
const showLayout = computed(() => !['/', '/register'].includes(route.path))
</script>

<style>
html, body {
  margin: 0;
  padding: 0;
  min-height: 100vh;
}

body {
  font-family: sans-serif;
  display: flex;
  flex-direction: column;
}

#app {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

/* Wrapper takes full height and stacks content properly */
.app-wrapper {
  display: flex;
  flex-direction: column;
  flex: 1;
  min-height: 100vh;
}

/* Main content grows and pushes footer down */
.main-content {
  flex-grow: 1;
  padding-bottom: 4rem; /* space above footer */
}

/* Background image behind everything */
body::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: url('/background.jpg') no-repeat center center fixed;
  background-size: cover;
  opacity: 0.15;
  z-index: -1;
  pointer-events: none;
}
</style>
