<template>
  <section class="user-dashboard">
    <h2>Welcome to Trimly Studio</h2>
    <p>Your appointments:</p>

    <div v-if="appointments.length">
      <div v-for="appt in appointments" :key="appt.id" class="card fade-in">
        <p><strong>{{ formatDate(appt.date) }} at {{ formatTime(appt.time) }}</strong></p>
        <button class="cancel-btn" @click="cancelAppointment(appt.id)">Cancel</button>
      </div>
    </div>
    <p v-else>No appointments yet. Book your first appointment below!</p>

    <button class="primary" @click="goToBooking">Book New Appointment</button>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const appointments = ref([])
const router = useRouter()

function logout() {
  localStorage.removeItem('token')
  router.push('/')
}

function goToBooking() {
  router.push('/book')
}

async function cancelAppointment(id) {
  const token = localStorage.getItem('token')
  await axios.delete(`http://localhost:8001/user-appointments.php?id=${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  })
  appointments.value = appointments.value.filter(a => a.id !== id)
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    weekday: 'short',
    month: 'short',
    day: 'numeric',
    year: 'numeric'
  })
}

function formatTime(time) {
  return new Date(`1970-01-01T${time}`).toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(async () => {
  const token = localStorage.getItem('token')
  const res = await axios.get('http://localhost:8001/user-appointments.php', {
    headers: { Authorization: `Bearer ${token}` }
  })
  appointments.value = res.data?.appointments || []
})
</script>

<style scoped>
.user-dashboard {
  max-width: 600px;
  margin: auto;
  padding: 2rem;
  text-align: center;
  position: relative;
}

.logout-btn {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: #ef4444;
  color: white;
  padding: 0.35rem 0.75rem;
  font-size: 0.85rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.3s ease;
}
.logout-btn:hover {
  background: #dc2626;
}

.card {
  background: #f3f4f6;
  margin-bottom: 1rem;
  padding: 1.2rem;
  border-radius: 6px;
  animation: fadeIn 0.3s ease;
}

button {
  margin: 0.5rem;
  padding: 0.5rem 1.2rem;
  border-radius: 4px;
  border: none;
  cursor: pointer;
}

.primary {
  background-color: #2b7fb8;
  color: white;
}

.cancel-btn {
  background-color: #d97706;
  color: white;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
