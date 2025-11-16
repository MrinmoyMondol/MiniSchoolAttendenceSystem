# 🎓 School Attendance System — Laravel + Vue.js

A mini school attendance management system built with a **Laravel REST API backend** and a **Vue.js SPA (Vite)** frontend.

---

## 📌 Requirements

Make sure the following are installed:

* **PHP 8+**
* **Composer**
* **Laravel 10+**
* **Node.js 16+**
* **MySQL**
* **Git**

---

## 🚀 Project Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/your-username/school-attendance.git
cd school-attendance
```

---

# 📦 Backend Setup (Laravel)

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Create Environment File

```bash
cp .env.example .env
```

### 4️⃣ Configure Database

Update `.env`:

```
DB_DATABASE=attendance_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Run Migrations

```bash
php artisan migrate
```

### 6️⃣ Run Seeder (optional demo data)

```bash
php artisan db:seed
```

### 7️⃣ Start Backend Server

```bash
php artisan serve
```

Backend will run at:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

# 🖥️ Frontend Setup (Vue + Vite)

Go to the front-end folder:

```bash
cd frontEnd
```

### 1️⃣ Install Node Dependencies

```bash
npm install
```

### 2️⃣ Run Development Server

```bash
npm run dev
```

Frontend will run at:
👉 **[http://localhost:5173](http://localhost:5173)**

---

## 🔗 API Base URL

Create `frontEnd/.env` and add:

```
VITE_API_URL=http://127.0.0.1:8000/api
```

---

## 📊 API Endpoints (Examples)

```
// Students
GET    /api/students
POST   /api/students
GET    /api/students/{id}
PUT    /api/students/{id}
DELETE /api/students/{id}

// Attendance
POST   /api/attendance/bulk
GET    /api/attendance/today
GET    /api/attendance/report/monthly?month=YYYY-MM
```



---

## 📁 Project Structure

```
school-attendance/
│
├── app/                 # Laravel backend
├── routes/
│   └── api.php
│
├── frontEnd/            # Vue.js Vite frontend
│   ├── src/
│   │   ├── views/
│   │   ├── router/
│   │   └── App.vue
│   ├── index.html
│   └── package.json
│
└── README.md
```

---

## 🧩 Features

✔ Student CRUD
✔ Bulk attendance marking
✔ Daily attendance summary
✔ Monthly attendance chart
✔ Vue.js SPA with Vue Router
✔ REST API (Laravel Resource)
✔ Axios API integration


