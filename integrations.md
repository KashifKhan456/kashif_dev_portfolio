# System Integrations & External Services

## 1. Database & Persistence Layer (MySQL)

- **Engine**: MySQL 8.x / MariaDB
- **ORM**: Laravel Eloquent
- **Connection Configuration**: `.env` driven parameters (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- **Features**: Foreign keys, transactions, and JSON attribute casting for tech stacks and tags.

---

## 2. Frontend Interactivity & UI Stack

### A. Vue 3 (Composition API)
- Utilizes `<script setup>` syntax across all page views and reusable components.

### B. Pinia State Management
- Reactive state management across views (`usePortfolioStore.js`).
- Handles resume modal lifecycle and client-side UI states.

### C. Styling & Icons
- **Tailwind CSS**: Dark stealth aesthetic, CSS variables, and modern responsive utilities.
- **Lucide Icons (`lucide-vue-next`)**: Vector iconography for tech badges, navigation dock, and admin panel.

---

## 3. Communication & Hardware Protocols

### A. Real-Time Hardware & Sockets (EPOS Ecosystem)
- WebSocket event channels for real-time kitchen order dispatching.
- Low-latency ESC/POS raw byte stream generation for 80mm network thermal printers via direct TCP sockets.

### B. Contact & Inquiries Delivery
- Laravel Mailable integration using standard SMTP for direct message forwarding and automated inquiry confirmations.
