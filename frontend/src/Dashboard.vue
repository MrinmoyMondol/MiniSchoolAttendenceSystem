<template>
  <div>
    <h2>Dashboard</h2>
    <div>
      <h3>Today's Summary</h3>
      <div>Total: {{ stats.total }} | Present: {{ stats.present }} | Absent: {{ stats.absent }} | Late: {{ stats.late }}</div>
    </div>

    <div>
      <h3>Monthly Attendance</h3>
      <canvas id="monthlyChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive } from 'vue';
import api from '../api/api.js';
import Chart from 'chart.js/auto';

const stats = reactive({ total:0, present:0, absent:0, late:0 });

async function loadStats(){
  const res = await api.get('/attendance/today');
  const arr = res.data;
  stats.total = arr.length;
  stats.present = arr.filter(a => a.status === 'present').length;
  stats.absent = arr.filter(a => a.status === 'absent').length;
  stats.late = arr.filter(a => a.status === 'late').length;
}

async function loadMonthlyChart(){
  const month = new Date().toISOString().slice(0,7); // YYYY-MM
  const res = await api.get('/attendance/report/monthly', { params: { month }});
  const data = res.data; // array of student attendance percentages
  const labels = data.map(d => d.student_id);
  const values = data.map(d => d.attendance_percentage);

  new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: { labels, datasets: [{ label: 'Attendance %', data: values }]},
    options: { responsive: true, scales: { y: { beginAtZero: true, max:100 } } }
  });
}

onMounted(async () => {
  await loadStats();
  await loadMonthlyChart();
});
</script>
