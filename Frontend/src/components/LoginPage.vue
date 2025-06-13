<template>
  <section class="login-section"> 
    <div class="login-box">
      <h1>Login</h1>
      <form @submit.prevent="handleLogin">
        <div class="text-field">
          <input type="text" v-model="email" required autocomplete="off" />
          <label><b>Email</b></label>
        </div>
        <div class="text-field">
          <input type="password" v-model="password" required autocomplete="off" />
          <label><b>Password</b></label>
        </div>
        <div class="LoginBTN">
          <input type="submit" value="Login" />
        </div>
        <p v-if="error" class="error-msg">{{ error }}</p>
      </form>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/api' // ✅ uses centralized axios instance

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

async function handleLogin() {
  try {
    const response = await api.post('/login.php', {
      email: email.value,
      password: password.value
    })
    localStorage.setItem('token', response.data.token)
    router.push('/dashboard')
  } catch (err) {
    error.value = err.response?.data?.error || 'Login failed'
  }
}
</script>

<style scoped>
.login-section {
  display: flex;
  justify-content: center;
  height: 100vh;
  align-items: center;
}

.login-box {
  width: 400px;
  padding: 2rem;
  background: #f5f5f5;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-weight: 600;
  font-size: 2rem;
  margin-bottom: 1rem;
  text-align: center;
}

.text-field {
  margin-bottom: 1.2rem;
}

label {
  display: block;
  font-size: 1rem;
  color: #333;
  margin-bottom: 0.4rem;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 0.6rem 1rem;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #fff;
  box-sizing: border-box;
}

.LoginBTN input {
  width: 100%;
  padding: 0.6rem;
  font-size: 1rem;
  border: none;
  border-radius: 6px;
  background-color: #2b7fb8;
  color: white;
  cursor: pointer;
  font-weight: bold;
}

.LoginBTN input:hover {
  background-color: #2563eb;
}

.LoginBTN input:active {
  transform: scale(0.98);
}

.error-msg {
  color: red;
  margin-top: 1rem;
  text-align: center;
}
</style>
