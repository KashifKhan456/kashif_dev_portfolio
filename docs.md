# Comprehensive Developer & Operational Documentation

## 1. Project Directory Structure

```
kashif-khan-portfolio/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LandingController.php      # Serves public portfolio views via Inertia
│   │       ├── ArticleShowController.php  # Public technical blog & article views
│   │       ├── ProjectShowController.php  # Public project showcase & detail views
│   │       ├── ContactController.php      # Processes contact form submissions
│   │       └── Admin/
│   │           ├── DashboardController.php# Admin dashboard metrics
│   │           ├── ArticleController.php  # Articles CMS management
│   │           ├── ProjectController.php  # Projects CRUD logic
│   │           ├── SkillController.php    # Skills CRUD logic
│   │           ├── ExperienceController.php# Experience CRUD logic
│   │           ├── TestimonialController.php# Testimonials management
│   │           └── SettingController.php  # Site profile & hero settings
│   ├── Models/
│   │   ├── Article.php
│   │   ├── Experience.php
│   │   ├── Message.php
│   │   ├── Project.php
│   │   ├── Setting.php
│   │   ├── Skill.php
│   │   ├── Testimonial.php
│   │   └── User.php
│   └── Services/                          # Service layer business logic
├── database/
│   ├── migrations/                        # DB schema definition files
│   └── seeders/                           # Seed initial portfolio & admin data
├── resources/
│   ├── js/
│   │   ├── app.js                         # Inertia + Vue 3 entry script
│   │   ├── Components/                    # Reusable UI components & MagicDock
│   │   ├── Layouts/
│   │   │   ├── GuestLayout.vue            # Public navigation & footer layout
│   │   │   └── AuthenticatedLayout.vue    # Admin dashboard layout
│   │   ├── Pages/
│   │   │   ├── Welcome.vue                # Main Portfolio Landing Page
│   │   │   ├── Articles/                  # Technical blog index & show views
│   │   │   ├── Projects/                  # Projects showcase & show views
│   │   │   ├── Auth/                      # Authentication pages
│   │   │   └── Admin/                     # Admin CMS section pages
│   │   └── stores/                        # Pinia state stores
│   │       └── usePortfolioStore.js
│   └── css/
│       └── app.css                        # Tailwind CSS styles & variables
├── routes/
│   ├── web.php                            # Inertia web routes & admin routes
│   └── auth.php                           # Authentication routes
├── architecture.md                        # Architecture documentation
├── features.md                            # Feature breakdown
├── docs.md                                # Developer guide (this file)
└── integrations.md                        # Third-party integrations
```

---

## 2. Environment Configuration (`.env`)

Ensure MySQL is running locally and configured in `.env`:

```env
APP_NAME="Kashif Khan Portfolio"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kashif_portfolio
DB_USERNAME=root
DB_PASSWORD=
```

---

## 3. Pinia State Management Guide

Pinia is configured in `resources/js/app.js`:

```javascript
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';

const pinia = createPinia();

createInertiaApp({
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .mount(el);
  },
});
```

---

## 4. Admin Access & Deployment

After running `php artisan migrate --seed`, access the Admin CMS panel:

- **Login URL**: `/login`
- **Dashboard URL**: `/admin/dashboard`

> [!IMPORTANT]
> In production environments, ensure you set a strong, unique administrator password and configure standard HTTPS/SSL certificates.
