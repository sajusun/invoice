# 🧾 Invozen – Invoice Builder SaaS Platform

**Invozen** is a modern invoice builder platform built using **Laravel 11 + Vue 3**.  
It enables businesses and individuals to generate, manage, and download professional invoices with advanced features like subscriptions, real-time notifications, and PDF exports.

---

## 🚀 Features
- 🧮 Dynamic Vue.js Invoice Builder
- 📄 PDF Export via Laravel DomPDF
- 💳 Subscription & Payment Gateway (Stripe, 2Checkout)
- 🔔 Real-time Notifications (Laravel Echo + Pusher)
- 🔐 Multi-guard Authentication (Admin, User)
- 📱 Responsive UI (Tailwind CSS)
- 💾 Secure File Management (Bitnami Permissions)

---

## 🛠️ Technologies
- Laravel 11
- Vue 3 + Vite
- Tailwind CSS
- Axios
- MySQL
- Stripe / 2Checkout
- DomPDF
- Laravel Broadcasting

---

## 🧩 Setup
```bash
git clone https://github.com/yourusername/invozen.git
cd invozen
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
