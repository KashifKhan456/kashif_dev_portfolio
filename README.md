# Kashif Khan - Premium Full-Stack Portfolio & Admin Dashboard

A state-of-the-art full-stack Developer Portfolio and dynamic Content Management System (CMS) built with **Laravel 11**, **Vue.js 3 (Composition API)**, **Inertia.js**, **Tailwind CSS**, **Shadcn UI components**, and **Pinia State Management**.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-Modern_Monolith-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![Pinia](https://img.shields.io/badge/Pinia-State_Management-FFE56E?style=for-the-badge&logo=vue.js&logoColor=black)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38BDF8?style=for-the-badge&logo=tailwindcss&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

---

## 🌟 Key Highlights

- **Dynamic Public Portfolio**: Modern glassmorphism UI, interactive project filterable showcase, animated timeline, real-time contact form, and live resume launcher.
- **Full-Featured Admin Dashboard**: Complete content management interface allowing live creation, editing, re-ordering, and removal of portfolio projects, technical skills, employment experience, and inbox inquiries.
- **Centralized Pinia State Management**: Clean reactive stores for managing UI state (dark mode, active filters, toast alerts, admin data caches, contact modal state).
- **MySQL Database Backend**: Robust relational database structure with automated migrations, factories, and seeders.
- **Inertia.js Monolith Architecture**: Zero-API boilerplate single-page application experience with server-driven routing and security.

---

## 📚 Documentation Directory

- 📐 [System Architecture (`architecture.md`)](./architecture.md)
- 🚀 [Feature Breakdown (`features.md`)](./features.md)
- 📖 [Comprehensive Documentation (`docs.md`)](./docs.md)
- 🧱 [Service Layer Architecture (`services.md`)](./services.md)
- 🔌 [Integrations & External Services (`integrations.md`)](./integrations.md)
- 🎨 [Design System & Typography (`design_system.md`)](./design_system.md)

---

## 🛠️ Quick Start

### 1. Prerequisites
- PHP `>= 8.2`
- Composer `>= 2.0`
- Node.js `>= 18.0`
- MySQL Server (XAMPP / Local MySQL Service)

### 2. Installation
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment template & generate app key
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration (`.env`)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kashif_portfolio
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate:fresh --seed
```

### 5. Launch Local Servers
```bash
# Terminal 1: Laravel Backend
php artisan serve

# Terminal 2: Vite Frontend HMR
npm run dev
```

Visit `http://127.0.0.1:8000` to view the public portfolio, or navigate to `/login` to access the Admin Panel.

