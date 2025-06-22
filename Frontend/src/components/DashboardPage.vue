<template>
  <section class="user-dashboard">
    <h2>Welcome to Trimly Studio</h2>
    <p>Your appointments:</p>

    <div v-if="appointments.length">
      <div v-for="appt in appointments" :key="appt.id" class="card fade-in">
        <p><strong>{{ formatDate(appt.date) }} at {{ formatTime(appt.time) }}</strong></p>
        <p class="description">
          <em>{{ appt.description }}</em>
        </p>

        <button class="cancel-btn" @click="cancelAppointment(appt.id)" :disabled="!canCancel(appt.date, appt.time)">
          Cancel
        </button>
        <button class="edit-btn" @click="editAppointment(appt)" :disabled="!canCancel(appt.date, appt.time)">
          Edit
        </button>
        <p v-if="!canCancel(appt.date, appt.time)" class="cancel-warning">
          Cannot cancel or edit within 30 minutes of appointment
        </p>
      </div>
    </div>
    <p v-else>No appointments yet. Book your first appointment below!</p>

    <button class="primary" @click="goToBooking">Book New Appointment</button>

    <div v-if="editing" class="modal">
      <div class="modal-content">
        <h3>Edit Appointment</h3>
        <form @submit.prevent="updateAppointment">
          <input v-model="form.date" type="date" required />
          <input v-model="form.time" type="time" required />
          <select v-model="form.service" required>
            <option value="">Select a service</option>
            <option value="Haircut">Haircut</option>
            <option value="Beard Trim">Beard Trim</option>
            <option value="Full Grooming">Full Grooming</option>
          </select>
          <textarea v-model="form.notes" placeholder="Notes (optional)"></textarea>

          <button type="submit">Update</button>
          <button @click="cancelEdit" type="button">Cancel</button>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const appointments = ref([])
const editing = ref(false)
const form = ref({ id: null, date: '', time: '', service: '', notes: '' })

const router = useRouter()

function goToBooking() {
  router.push('/book')
}

async function cancelAppointment(id) {
  const token = localStorage.getItem('token')
  await axios.delete(`http://localhost:8001/user-appointments.php?id=${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  })
  await fetchAppointments()
}

function editAppointment(appt) {
  editing.value = true
  const [service, notes = ''] = appt.description.split(' - ')
  form.value = {
    id: appt.id,
    date: appt.date,
    time: appt.time,
    service: service.trim(),
    notes: notes.trim()
  }

}

function cancelEdit() {
  editing.value = false
  form.value = { id: null, date: '', time: '', description: '' }
}

async function updateAppointment() {
  const token = localStorage.getItem('token')
  const description = `${form.value.service} - ${form.value.notes}`

  await axios.put(
    'http://localhost:8001/user-appointments.php',
    {
      id: form.value.id,
      date: form.value.date,
      time: form.value.time,
      description
    },
    { headers: { Authorization: `Bearer ${token}` } }
  )

  await fetchAppointments()
  cancelEdit()
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

function canCancel(dateStr, timeStr) {
  const apptDateTime = new Date(`${dateStr}T${timeStr}`)
  const now = new Date()
  const diffMs = apptDateTime - now
  const diffMinutes = diffMs / (1000 * 60)
  return diffMinutes >= 30
}

async function fetchAppointments() {
  const token = localStorage.getItem('token')
  const res = await axios.get('http://localhost:8001/user-appointments.php', {
    headers: { Authorization: `Bearer ${token}` }
  })
  appointments.value = res.data?.appointments || []
}

onMounted(fetchAppointments)
</script>

<style scoped>
.user-dashboard {
  max-width: 600px;
  margin: auto;
  padding: 2rem;
  text-align: center;
  position: relative;
  padding-bottom: 5rem;
}

.card {
  background: #d9d9d9c2;
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

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
  opacity: 0.6;
}

.primary {
  background-color: #2b7fb8;
  color: white;
}

.cancel-btn {
  background-color: #d97706;
  color: white;
}

.edit-btn {
  background-color: #10b981;
  color: white;
}

.cancel-warning {
  font-size: 0.85rem;
  color: red;
  margin-top: 0.3rem;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  min-width: 300px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  animation: pop-in 0.3s ease forwards;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(8px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes pop-in {
  from {
    transform: scale(0.9);
    opacity: 0;
  }

  to {
    transform: scale(1);
    opacity: 1;
  }
}

.description {
  font-size: 0.95rem;
  color: #374151;
  margin-top: 0.5rem;
}
</style>
