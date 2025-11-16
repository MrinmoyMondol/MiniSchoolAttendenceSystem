import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import StudentList from '../views/StudentList.vue'
import Attendance from '../views/Attendance.vue'

const routes = [
    { path: '/', component: Dashboard }, // 👈 front page
    { path: '/students', component: StudentList },
    { path: '/attendance', component: Attendance },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router