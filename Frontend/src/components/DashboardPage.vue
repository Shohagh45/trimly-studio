<template>
  <section class="dashboard">
    <h1>Dashboard</h1>
    <p>You are now logged in! 🎉</p>
    <button @click="logout">Logout</button>
  </section>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function logout() {
  localStorage.removeItem('token')
  router.push('/')
}
</script>

<style scoped>
.dashboard {
  padding: 2rem;
  text-align: center;
  font-family: sans-serif;
}

button {
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background-color: #ef4444;
  border: none;
  border-radius: 4px;
  color: white;
  cursor: pointer;
}

button:hover {
  background-color: #dc2626;
}
</style>
