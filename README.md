School Attendance System — Laravel + Vue.js

A mini school attendance management system built with a Laravel REST API backend and a Vue.js SPA frontend.

📌 Requirements

Make sure you have the following installed:

PHP 8+

Composer

Laravel 10+

Node.js 16+

MySQL or MariaDB

Git

🚀 Project Setup Instructions
1. Clone the Repository
git clone https://github.com/your-username/school-attendance.git
cd school-attendance

📦 Backend Setup (Laravel)
2. Install Dependencies
composer install

3. Create Environment File
cp .env.example .env

4. Configure Database

Update your .env file:

DB_DATABASE=attendance_db
DB_USERNAME=root
DB_PASSWORD=

5. Run Migrations
php artisan migrate

6. Run Seeder (if you added demo data)
php artisan db:seed

7. Start Backend Server
php artisan serve

🖥️ Frontend Setup (Vue.js)

Go to the frontend folder:

cd frontEnd

1. Install Node Dependencies
npm install

2. Run Development Server
npm run dev


Frontend will run at:

👉 http://localhost:5173
