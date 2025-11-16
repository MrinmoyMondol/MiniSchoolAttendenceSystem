<template>
  <div>
    <h2>Attendance Recorder</h2>
    <div>
      <label>Class</label>
      <select v-model="selectedClass" @change="loadStudents">
        <option value="">Select</option>
        <option v-for="c in classes" :key="c">{{ c }}</option>
      </select>
      <label>Section</label>
      <input v-model="selectedSection" />
      <button @click="loadStudents">Load Students</button>
    </div>

    <div v-if="students.length">
      <table>
        <thead><tr><th>Student</th><th>Status</th><th>Note</th></tr></thead>
        <tbody>
          <tr v-for="s in students" :key="s.id">
            <td>{{ s.name }}</td>
            <td>
              <select v-model="attendance[s.id]">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
                <option value="late">Late</option>
              </select>
            </td>
            <td><input v-model="notes[s.id]" /></td>
          </tr>
        </tbody>
      </table>
      <button @click="markAll('present')">Mark All Present</button>
      <button @click="submitAttendance">Submit</button>
      <div>Attendance %: {{ attendancePercentage }}</div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import api from '../api/api.js';

const classes = ['1','2','3','4','5','6','7','8','9','10'];
const selectedClass = ref('');
const selectedSection = ref('');
const students = ref([]);
const attendance = ref({});
const notes = ref({});

async function loadStudents() {
  if (!selectedClass.value) return;
  const res = await api.get('/students', { params: { class: selectedClass.value, page: 1 }});
  students.value = res.data.data;
  students.value.forEach(s => {
    attendance.value[s.id] = 'present';
    notes.value[s.id] = '';
  });
}

function markAll(status) {
  students.value.forEach(s => attendance.value[s.id] = status);
}

const attendancePercentage = computed(() => {
  if (!students.value.length) return 0;
  const total = students.value.length;
  const present = students.value.filter(s => attendance.value[s.id] === 'present').length;
  return Math.round((present / total) * 100);
});

async function submitAttendance() {
  const payload = {
    date: new Date().toISOString().split('T')[0],
    records: students.value.map(s => ({
      student_id: s.id,
      status: attendance.value[s.id],
      note: notes.value[s.id] || null
    }))
  };
  await api.post('/attendance/bulk', payload);
  alert('Attendance submitted');
}
</script>
