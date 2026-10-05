# System Architecture & Technical Specifications

## 1. High-Level Architecture Overview

The system uses the **Inertia.js Modern Monolith** pattern with **Laravel 11** powering backend business logic, ORM models, authentication, and database transactions, while **Vue 3 (Composition API)** handles client-side view rendering, interactivity, and UI state management.

```
                  +-----------------------------------+
                  |        Browser / Client           |
                  |  Vue 3 + Pinia + Tailwind CSS     |
                  +-----------------+-----------------+
                                    |
                          Inertia.js Protocol
                                    |
                  +-----------------v-----------------+
                  |         Laravel 11 Kernel         |
                  | Controllers | Middleware | Auth   |
                  +-----------------+-----------------+
                                    |
                             Eloquent ORM
                                    |
                  +-----------------v-----------------+
                  |          MySQL Database           |
                  | (Projects, Articles, Skills, etc) |
                  +-----------------------------------+
```

---

## 2. Client State Architecture

### A. Pinia Store (`resources/js/stores/usePortfolioStore.js`)
- Manages global modal view states (e.g., in-app resume viewer lifecycle, active document URLs).
- Handles responsive document preview logic across mobile and desktop devices.

### B. Composables (`resources/js/Composables/useTheme.js`)
- Persists Dark / Light theme preferences into `localStorage` with system color scheme detection.

---

## 3. Database Entity Relationship Diagram (ERD)

```
+-------------------+       +-------------------+       +-------------------+
|       Users       |       |     Projects      |       |      Skills       |
+-------------------+       +-------------------+       +-------------------+
| id (PK)           |       | id (PK)           |       | id (PK)           |
| name              |       | title             |       | name              |
| email             |       | slug              |       | category          |
| password          |       | summary           |       | icon              |
| remember_token    |       | description       |       | order             |
| created_at        |       | image_path        |       | is_featured       |
| updated_at        |       | tech_stack (json) |       +-------------------+
+-------------------+       | demo_url          |
                            | github_url        |       +-------------------+
+-------------------+       | is_featured       |       |    Experiences    |
|     Articles      |       | order             |       +-------------------+
+-------------------+       +-------------------+       | id (PK)           |
| id (PK)           |                                   | company           |
| title             |       +-------------------+       | role              |
| slug (unique)     |       |   Testimonials    |       | period            |
| excerpt           |       +-------------------+       | description       |
| content (html)    |       | id (PK)           |       | order             |
| cover_image       |       | author_name       |       +-------------------+
| read_time         |       | author_title      |
| tags (json)       |       | author_avatar     |       +-------------------+
| is_published      |       | content           |       |     Settings      |
| published_at      |       | rating            |       +-------------------+
| views_count       |       | is_active         |       | id (PK)           |
| order             |       | order             |       | key (unique)      |
+-------------------+       +-------------------+       | value (text)      |
                                                        +-------------------+
```

---

## 4. Security & Middleware Layer

- **Authentication**: Laravel Session-based Auth protecting all `/admin/*` routes.
- **CSRF Protection**: Native Laravel CSRF tokens validated on all mutating requests.
- **Sanitization**: Form request validation rules enforcing strict validation on portfolio CMS forms.
- **Rate Limiting**: Contact endpoint throttling to prevent automated spam.
