<template>
  <div>
    <h2>Students</h2>
    <div>
      <input v-model="search" placeholder="Search name or id" @input="fetchStudents" />
      <select v-model="filterClass" @change="fetchStudents">
        <option value="">All classes</option>
        <option v-for="c in classes" :key="c" :value="c">{{ c }}</option>
      </select>
    </div>

    <table>
      <thead><tr><th>#</th><th>Name</th><th>Student ID</th><th>Class</th><th>Section</th></tr></thead>
      <tbody>
        <tr v-for="student in students.data" :key="student.id">
          <td>{{ student.id }}</td>
          <td>{{ student.name }}</td>
          <td>{{ student.student_id }}</td>
          <td>{{ student.class }}</td>
          <td>{{ student.section }}</td>
        </tr>
      </tbody>
    </table>

    <div v-if="students.meta">
      <button @click="changePage(students.meta.current_page - 1)" :disabled="students.meta.current_page<=1">Prev</button>
      <span>Page {{ students.meta.current_page }} / {{ students.meta.last_page }}</span>
      <button @click="changePage(students.meta.current_page + 1)" :disabled="students.meta.current_page>=students.meta.last_page">Next</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../api/api.js';

const students = ref({data:[], meta:null});
const search = ref('');
const filterClass = ref('');
const classes = ref(['1','2','3','4','5','6','7','8','9','10']); // adapt as needed
const page = ref(1);

async function fetchStudents() {
  const res = await api.get('/students', { params: { search: search.value, class: filterClass.value, page: page.value }});
  students.value = res.data;
}
function changePage(p) {
  page.value = p; fetchStudents();
}

onMounted(fetchStudents);
</script>
