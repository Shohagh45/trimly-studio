<template>
  <section class="admin-dashboard">
    <h2>Admin Panel</h2>

    <table v-if="appointments.length">
      <thead>
        <tr>
          <th>User</th>
          <th>Date</th>
          <th>Time</th>
          <th>Service</th>
          <th>Notes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="appt in appointments" :key="appt.id" class="fade-in">
          <td>{{ appt.user_email }}</td>
          <td>{{ formatDate(appt.date) }}</td>
          <td>{{ formatTime(appt.time) }}</td>
          <td>{{ parseDescription(appt.description).service }}</td>
          <td>{{ parseDescription(appt.description).notes || '-' }}</td>


          <td>
            <button @click="editAppointment(appt)">✏️ Edit</button>
            <button @click="deleteAppointment(appt.id)">🗑 Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="appointments.length === 0" style="margin-top: 1rem;">No appointments found.</p>

    <div v-if="editing" class="modal">
      <div class="modal-content">
        <h3>Edit Appointment</h3>
        <form @submit.prevent="updateAppointment">
          <input v-model="form.date" type="date" required />
          <input v-model="form.time" type="time" required />
          <select v-model="form.service" required>
            <option disabled value="">Select a service</option>
            <option>Haircut</option>
            <option>Beard Trim</option>
            <option>Full Grooming</option>
          </select>

          <textarea v-model="form.notes" placeholder="Optional notes..."></textarea>


          <button type="submit">Update</button>
          <button @click="cancelEdit" type="button">Cancel</button>
        </form>
      </div>
    </div>
    <div class="top-bar">
    </div>

  </section>
</template>

<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()
import { ref, onMounted } from 'vue'
import axios from 'axios'

const appointments = ref([])
const editing = ref(false)
const form = ref({ id: null, date: '', time: '', description: '' })

function parseDescription(description) {
  if (!description) return { service: '', notes: '' };
  const [service, notes] = description.split(' - ');
  return {
    service: service?.trim() || '',
    notes: notes?.trim() || ''
  };
}


async function fetchAppointments() {
  const token = localStorage.getItem('token')
  const res = await axios.get('http://localhost:8001/admin/admin-appointments.php', {
    headers: { Authorization: `Bearer ${token}` }
  })
  appointments.value = res.data
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
  const payload = {
    ...form.value,
    description: `${form.value.service} - ${form.value.notes}`
  }

  await axios.put(
    'http://localhost:8001/admin/admin-appointments.php',
    payload,
    { headers: { Authorization: `Bearer ${token}` } }
  )

  await fetchAppointments()
  cancelEdit()
}



async function deleteAppointment(id) {
  const token = localStorage.getItem('token')
  await axios.delete(`http://localhost:8001/admin/admin-appointments.php?id=${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  })
  appointments.value = appointments.value.filter(a => a.id !== id)
}

// Formatting helpers
function formatDate(date) {
  return new Date(date).toLocaleDateString('en-US', {
    weekday: 'short',
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

function formatTime(time) {
  return new Date(`1970-01-01T${time}`).toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  })
}
function logout() {
  localStorage.removeItem('token')
  localStorage.removeItem('role')
  router.push('/')
}

onMounted(fetchAppointments)
</script>

<style scoped>
.admin-dashboard {
  padding: 2rem;
}

th,
td {
  text-align: left;
  /* Or use 'center' if you want them centered */
  padding: 0.75rem;
  border-bottom: 1px solid #eee;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: #f1f1f1;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
}

th,
td {
  padding: 0.75rem;
  border-bottom: 1px solid #eee;
}

button {
  margin-right: 0.5rem;
  background: #3b82f6;
  color: white;
  padding: 0.4rem 0.8rem;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #2563eb;
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

.fade-in {
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
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

.top-bar {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 1rem;
}

.logout-btn {
  background: #ef4444;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  transition: background 0.3s ease;
}

.logout-btn:hover {
  background: #dc2626;
}
</style>
