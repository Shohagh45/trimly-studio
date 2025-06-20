# Trimly Studio

A simple barbershop appointment booking app using Vue 3, PHP (no framework), and JWT authentication.

## 🛠 Tech Stack
- Vue 3 (Vite, Pinia, Vue Router)
- PHP 8.2 (custom API, JWT)
- Docker + MariaDB + phpMyAdmin

## 🧪 Test Accounts

### Admin
- **Email**: user@example.com
- **Password**: password123
### User
- **Email**: shohagh@gmail.com
- **Password**: 1234

### User
- Register via frontend

## 🚀 How to Run

### Backend
```bash
cd Backend
docker-compose up --build

### Frontend 
cd Frontend
npm install
npx vite --port 5174


## ✅ Progress Summary

- [x] JWT login flow (backend + frontend)
- [x] Dockerized PHP, MariaDB, phpMyAdmin
- [x] Role-based routing (admin/user)
- [x] Register endpoint (working)
- [x] Dashboard + protected routes
- [x] Appointment creation (WIP)

