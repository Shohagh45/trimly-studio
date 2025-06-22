<template>
  <div class="register-box">
    <h1>Register</h1>
    <form @submit.prevent="registerUser">
      <input v-model="email" placeholder="Email" required />
      <input type="password" v-model="password" placeholder="Password" required />
      <button type="submit">Register</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const message = ref('')
const router = useRouter()

async function registerUser() {
  try {
    const res = await axios.post(
      'http://localhost:8001/register.php',
      { email: email.value, password: password.value }
    )
    message.value = res.data.message
    // Optionally auto-redirect to login after registration:
    setTimeout(() => router.push('/'), 1500)
  } catch (err) {
    message.value = err.response?.data?.message || 'Registration failed'
  }
}
</script>

<style scoped>
.register-box {
  width: 300px;
  margin: 2rem auto;
  padding: 2rem;
  background: #f5f5f5;
  border-radius: 10px;
  text-align: center;
}

input {
  width: 100%;
  margin: .5rem 0;
  padding: .5rem;
}

button {
  margin-top: 1rem;
  padding: .5rem 1rem;
}

p {
  margin-top: .5rem;
  color: #333;
}
</style>
