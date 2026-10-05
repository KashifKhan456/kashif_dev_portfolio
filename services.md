# 🧱 Service Layer & Thin Controllers Architecture (`services.md`)

To maintain clean code separation, testability, and slim controllers, this project enforces the **Form Request + Service Layer Architecture**.

---

## 🏛️ Architectural Flow

```
HTTP Request 
   │
   ▼
Form Request Class (app/Http/Requests/*)
   │ (Validation & Authorization)
   ▼
Controller Action (app/Http/Controllers/*)
   │ (Thin Delegate - 1 to 3 lines)
   ▼
Service Class (app/Services/*)
   │ (Business Logic, DB Transactions, Model Manipulation)
   ▼
Inertia Response / Redirect Response
```

---

## 📁 Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── LandingController.php        (Delegates to LandingService)
│   │   ├── ArticleShowController.php    (Delegates to ArticleService)
│   │   ├── ProjectShowController.php    (Delegates to ProjectService)
│   │   ├── ContactController.php        (Delegates to ContactService)
│   │   └── Admin/
│   │       ├── DashboardController.php  (Delegates to DashboardService)
│   │       ├── ArticleController.php    (Delegates to ArticleService)
│   │       ├── ProjectController.php    (Delegates to ProjectService)
│   │       ├── SkillController.php      (Delegates to SkillService)
│   │       ├── ExperienceController.php (Delegates to ExperienceService)
│   │       ├── TestimonialController.php(Delegates to TestimonialService)
│   │       └── SettingController.php    (Delegates to SettingService)
│   │
│   └── Requests/
│       ├── ContactRequest.php
│       └── Admin/
│
└── Services/
    ├── LandingService.php
    ├── ArticleService.php
    ├── ContactService.php
    ├── DashboardService.php
    ├── ProjectService.php
    ├── SkillService.php
    ├── ExperienceService.php
    ├── TestimonialService.php
    └── SettingService.php
```

---

## 📋 Architectural Rules

1. **No Inline Validation in Controllers**: Controllers must never execute inline request validation arrays. Always type-hint a dedicated `FormRequest` class.
2. **No Direct Eloquent Mutations in Controllers**: Complex database interactions and queries belong inside `app/Services/`.
3. **Controller Responsibilities**: Controllers only coordinate request validation, call services, and return Inertia view responses.
4. **Service Class Responsibilities**: Services execute database persistence, slug formatting, file uploads, notifications, and aggregate metrics.
