<template>
  <div class="appointment-form">
    <h2>Book a Trim</h2>
    <form @submit.prevent="submitAppointment">
      <label>Date</label>
      <input type="date" v-model="date" required />

      <label>Time</label>
      <input type="time" v-model="time" required />

      <label>Service</label>
      <select v-model="service">
        <option>Haircut</option>
        <option>Beard Trim</option>
        <option>Full Grooming</option>
      </select>

      <label>Notes</label>
      <textarea v-model="notes" rows="3" placeholder="Optional..."></textarea>

      <button type="submit">Confirm Appointment</button>
      <p v-if="success" style="color: green; margin-top: 1rem;">{{ success }}</p>
      <p v-if="error" style="color: red; margin-top: 1rem;">{{ error }}</p>
    </form>

    <div class="nav-buttons">
      <button class="secondary" @click="goToDashboard">Go to Dashboard</button>
      <button class="logout" @click="logout">Logout</button>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import axios from 'axios'

const router = useRouter()
const date = ref('')
const time = ref('')
const service = ref('Haircut')
const notes = ref('')
const success = ref('')
const error = ref('')

async function submitAppointment() {
  const token = localStorage.getItem('token')
  try {
    const response = await axios.post(
      'http://localhost:8001/user-appointments.php',
      {
        date: date.value,
        time: time.value,
        description: `${service.value} - ${notes.value}`
      },
      {
        headers: { Authorization: `Bearer ${token}` }
      }
    )
    success.value = response.data?.message || 'Appointment booked!'
    error.value = ''
    date.value = ''
    time.value = ''
    notes.value = ''
    router.push('/dashboard')
  } catch (err) {
    error.value = err.response?.data?.message || 'Failed to create appointment'
    success.value = ''
  }
}

function goToDashboard() {
  router.push('/dashboard')
}

function logout() {
  localStorage.removeItem('token')
  router.push('/')
}
</script>

<style scoped>
.appointment-form {
  max-width: 500px;
  margin: 3rem auto 6rem; /* bottom margin for footer spacing */
  padding: 2rem;
  border-radius: 10px;
  background-color: #10101042;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}


label {
  display: block;
  margin-top: 1rem;
  font-weight: 500;
}

input,
select,
textarea {
  width: 100%;
  padding: 0.5rem;
  margin-top: 0.25rem;
  border: 1px solid #ccc;
  border-radius: 6px;
}

button {
  margin-top: 1.5rem;
  width: 100%;
  background: #2b7fb8;
  color: white;
  padding: 0.75rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
}

.nav-buttons {
  margin-top: 1.5rem;
  display: flex;
  justify-content: space-between;
  gap: 1rem;
}

.secondary {
  background: #6b7280;
  color: white;
  border: none;
  padding: 0.5rem;
  border-radius: 6px;
  flex: 1;
}

.logout {
  background: #ef4444;
  color: white;
  border: none;
  padding: 0.5rem;
  border-radius: 6px;
  flex: 1;
}
</style>
