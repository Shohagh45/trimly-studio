<template>
  <header class="site-header">
    <nav class="nav-links">
      <div class="logo">
        <img src="/logos.svg" alt="Trimly Studio" class="logo" />
      </div>
      <div class="links">
        <router-link to="/" v-if="!isLoggedIn">Login</router-link>
        <router-link to="/register" v-if="!isLoggedIn">Register</router-link>

        <router-link to="/dashboard" v-if="isLoggedIn && !isAdmin">Dashboard</router-link>
        <router-link to="/book" v-if="isLoggedIn && !isAdmin">Book</router-link>
        <router-link to="/admin" v-if="isAdmin">Admin</router-link>


        <router-link to="/team">OurTeam</router-link>
        <router-link to="/contact">Contact</router-link>
        <router-link to="/about">About</router-link>
      </div>
      <button v-if="isLoggedIn" @click="logout" class="logout-btn">Logout</button>
    </nav>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const token = localStorage.getItem('token')
const payload = token ? JSON.parse(atob(token.split('.')[1])) : null

const isLoggedIn = computed(() => !!token)
const isAdmin = computed(() => payload?.role === 'admin')

function logout() {
  localStorage.removeItem('token')
  router.push('/')
}
</script>

<style scoped>
.site-header {
  background: #000000;
  padding: 1rem;
  color: rgb(41, 35, 35);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav-links {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.links a {
  margin: 0 1rem;
  color: rgb(247, 242, 242);
  text-decoration: none;
  font-weight: bold;
}

.links a.router-link-exact-active {
  text-decoration: underline;
}

.logout-btn {
  background-color: #ef4444;
  color: white;
  border: none;
  padding: 0.4rem 0.8rem;
  border-radius: 4px;
  cursor: pointer;
}

.logout-btn:hover {
  background-color: #dc2626;
}

.logo-text {
  font-size: 1.2rem;
  font-weight: bold;
  color: white;
  margin-right: 1.5rem;
  text-decoration: none;
}

.logo img {
  height: 50px;
  width: auto;
  object-fit: contain;
}
</style>
