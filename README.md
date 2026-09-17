<p align="center">
  <a href="https://invozen.test">
    <img src="public/assets/logo.png" alt="Invozen Logo" width="130" onerror="this.style.display='none'">
  </a>
</p>

<h1 align="center">🧾 Invozen — Modern Financial Invoicing & Billing SaaS</h1>

<p align="center">
  <strong>Enterprise-ready Multi-Tenant Invoicing, Dynamic Stripe Subscriptions, Developer APIs, and RBAC Platform.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12+" />
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.4" />
  <img src="https://img.shields.io/badge/Vue.js-3.5-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue 3.5" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Stripe-API_v17-635BFF?style=for-the-badge&logo=stripe&logoColor=white" alt="Stripe API" />
  <img src="https://img.shields.io/badge/Vite-6.0-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite 6" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License" />
</p>

---

## 📑 Table of Contents
1. [🎯 Project Vision & Intentions](#-project-vision--intentions)
2. [🏛️ Core System Architecture & Modules](#️-core-system-architecture--modules)
   - [Invoicing & PDF Rendering Engine](#1-invoicing--pdf-rendering-engine)
   - [Stripe Recurring Billing & Dynamic Tier System](#2-stripe-recurring-billing--dynamic-tier-system)
   - [Financial Reporting & Analytics Dashboard](#3-financial-reporting--analytics-dashboard)
   - [Customer Management (CRM)](#4-customer-management-crm)
   - [Developer RESTful API & Webhook Dispatcher (V1)](#5-developer-restful-api--webhook-dispatcher-v1)
   - [Enterprise RBAC & Granular Permission Matrix](#6-enterprise-rbac--granular-permission-matrix)
   - [Dual-Guard Multi-Auth & Session Isolation](#7-dual-guard-multi-auth--session-isolation)
3. [🛠️ Technology Stack](#️-technology-stack)
4. [📂 Codebase Directory Layout](#-codebase-directory-layout)
5. [⚡ Installation & Local Development Setup](#-installation--local-development-setup)
6. [🔐 Default Credentials & Seeding Matrix](#-default-credentials--seeding-matrix)
7. [📡 Developer REST API Reference (V1)](#-developer-rest-api-reference-v1)
8. [⚙️ Environment Configuration (`.env`)](#️-environment-configuration-env)
9. [🧪 Testing & Quality Assurance](#-testing--quality-assurance)
10. [📜 License & Credits](#-license--credits)

---

## 🎯 Project Vision & Intentions

**Invozen** is built to bridge the gap between simple invoice generators and complex enterprise billing systems. It provides freelancers, agencies, and businesses with an all-in-one financial ecosystem:

1. **Effortless Invoicing**: Generate professional vector PDF invoices with real-time tax, discount, and multi-currency calculations.
2. **Predictable Recurring Revenue**: Native integration with Stripe supporting flexible billing (Monthly and Annual with automatic 20% savings), automated checkout sessions, and webhook synchronization.
3. **Developer-First Extensibility**: Turn Invozen into an *Invoicing-as-a-Service* backend using scoped Bearer API tokens and outbound webhook notifications.
4. **Institutional Security & Access Control**: Complete administrative control with custom roles, granular permission matrices, and isolated user/admin session states.

---

## 🏛️ Core System Architecture & Modules

```mermaid
graph TD
    UserClient[User / Business Owner] -->|Manages Invoices, CRM, Reports| UserPanel[User Dashboard: web guard]
    DeveloperApp[External Apps / Integrations] -->|Bearer API Key| V1Api[RESTful API v1: auth.api_key]
    StaffAdmin[SuperAdmin & Staff] -->|Manages Platform, Plans, Roles| AdminPanel[Admin Dashboard: admin guard]
    
    UserPanel --> InvoicingEngine[Invoicing & PDF Engine]
    UserPanel --> StripeBilling[Stripe Billing & Metering]
    UserPanel --> ReportingModule[Financial Reports & Analytics]
    
    AdminPanel --> AclEngine[RBAC & Permission Matrix]
    AdminPanel --> UserManagement[User & Subscription Audit]
```

### 1. Invoicing & PDF Rendering Engine
- **Live Reactive Builder**: Dynamic line items, automatic subtotal calculating, multi-tier tax computations, flat/percentage discounts, shipping, and notes.
- **Vector PDF Pipeline**: Generates crisp, branded accounting statements and receipts via `barryvdh/laravel-dompdf`.
- **Status Lifecycle Workflow**: Tracks invoice states: `Draft` ➔ `Pending` ➔ `Paid` ➔ `Overdue` ➔ `Cancelled`.
- **Direct Email Dispatch**: One-click emailing of invoices and payment receipts with customizable templates.
- **Bulk Operations**: Multi-select bulk status updates, invoice batch deletion, and duplication mechanisms.

### 2. Stripe Recurring Billing & Dynamic Tier System
- **Tiered Plans**: `Free Starter`, `Professional ($19/mo)`, `Enterprise ($49/mo)`.
- **Dynamic Annual Discount Engine**: Real-time 20% discount calculation when switching billing cycles from Monthly to Annual.
- **Stripe Checkout Integration**: Seamless offloaded payment processing with Webhook handlers (`checkout.session.completed`, `customer.subscription.deleted`).
- **Quota Enforcers**: Visual progress meters tracking monthly invoice counts, customer quotas, and plan expiration countdowns guarded by `CheckPlanExpiry` middleware.

### 3. Financial Reporting & Analytics Dashboard
- **Executive Overview (`/dashboard/reports`)**: Interactive revenue trends (Chart.js), collection efficiency ratios, and paid vs unpaid breakdown.
- **Preset & Custom Date Filtering**: `Last 7 Days`, `Last 30 Days`, `This Month`, `This Year`, and custom date pickers.
- **Exporting Capabilities**: Export ledger statements to **CSV** or branded **PDF Accounting Statements**.

### 4. Customer Management (CRM)
- Centralized client database storing company name, contact person, billing address, and tax identification numbers (VAT, GST, EIN).
- Customer-specific invoice history ledger with lifetime value tracking.

### 5. Developer RESTful API & Webhook Dispatcher (V1)
- **Scoped API Tokens (`/dashboard/developer/api-keys`)**: Generate and manage API secret keys (`Bearer inv_live_sk_...`) with rate-limiting (`120 req/min`).
- **Invoicing-as-a-Service Endpoints**: Programmatically create, update, fetch, delete, mark as paid, and stream PDF invoices.
- **Event Webhook Subscriptions**: Subscribe external endpoints to lifecycle events (e.g. `invoice.created`, `invoice.paid`).

### 6. Enterprise RBAC & Granular Permission Matrix
- **Custom Role Builder (`/admin/dashboard/roles`)**: Create custom administrator roles (e.g. *Finance Manager*, *Support Executive*, *Compliance Officer*).
- **Matrix Permissions**: Fine-grained capability toggles (`manage_invoices`, `manage_customers`, `manage_payments`, `manage_users`, `manage_roles`, `manage_settings`, `manage_plans`).
- **Staff Directory**: Interactive role switcher dropdowns with live permission badge previews.
- **SuperAdmin Safeguards**: Root policy protection preventing self-demotion or accidental SuperAdmin deletion.

### 7. Dual-Guard Multi-Auth & Session Isolation
- Separate `web` (`App\Models\User`) and `admin` (`App\Models\Admin`) authentication providers.
- **Isolated Session Lifecycle**: Logging out from the user dashboard does not terminate active administrative sessions in the same browser, and vice versa.
- Protected by `auth:admin`, `admin` (`AdminMiddleware`), and `AuthNeed` security layer.

---

## 🛠️ Technology Stack

| Layer | Component | Version / Specification |
| :--- | :--- | :--- |
| **Runtime Environment** | PHP | **8.4.x** (CLI & FPM) |
| **Backend Framework** | Laravel | **12.x** |
| **Frontend Framework** | Vue.js | **3.5.x** (Composition API) |
| **Interactivity Layer** | Alpine.js | **3.4.x** |
| **Styling & Design System** | Tailwind CSS | **3.4.x** with `@tailwindcss/forms` |
| **Build Tooling & Bundler** | Vite | **6.0.x** with `@vitejs/plugin-vue` |
| **Payment Gateway** | Stripe PHP SDK | **v17.3** |
| **PDF Rendering** | DomPDF | **v3.1** |
| **Realtime WebSockets** | Laravel Reverb / Pusher | Laravel Echo + `pusher-js` |
| **Database** | MySQL / MariaDB | **8.0+** / **10.6+** |
| **Testing Framework** | Pest PHP | **v3.7** |

---

## 📂 Codebase Directory Layout

```
invozen/
├── app/
│   ├── Events/               # Realtime broadcast events (AdminNotification, InvoicePaid)
│   ├── Helpers/              # Global helpers (AdminNotifier)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        # Admin SaaS Dashboard, Roles, Users, Payments
│   │   │   ├── Api/V1/       # RESTful Invoicing & Customers API (V1)
│   │   │   ├── Auth/         # Breeze User Authentication Controllers
│   │   │   └── ...           # Invoices, Reports, Settings, Stripe Billing
│   │   └── Middleware/       # AdminMiddleware, CheckPlanExpiry, AuthenticateApiKey
│   ├── Models/               # Eloquent Models (User, Admin, Role, Invoices, Payment, Plan)
│   ├── Modules/
│   │   └── Acl/              # RolePermissionService & HasRolesAndPermissions Trait
│   └── Services/             # Business Logic & AuthNeed ACL Gatekeeper
├── bootstrap/                # Application bootstrap & middleware aliases (Laravel 12)
├── config/                   # Configuration files (auth, stripe, database, dompdf)
├── database/
│   ├── migrations/           # Database schema migrations
│   └── seeders/              # AdminSeeder, PlanSeeder, RolesAndPermissionsSeeder
├── resources/
│   ├── css/                  # dashboard.css, app.css
│   ├── js/                   # Vue components, app.js, echo.js
│   └── views/
│       ├── admin/            # Admin Blade views & Role permission matrix
│       ├── custom-components/# Dashboard asides, navbars, cards
│       ├── invoices/         # Invoice views & builder templates
│       ├── pdf/              # DomPDF vector invoice & report templates
│       └── settings/         # Business profile & invoice mockup preview
├── routes/
│   ├── web.php               # User facing routes & middleware groups
│   ├── api.php               # Developer API (V1) endpoints
│   ├── admin_routes.php      # Admin SaaS management routes
│   └── admin/admin_auth.php  # Admin profile, role matrix & staff routes
└── tests/                    # Pest PHP automated feature & unit test suite
```

---

## ⚡ Installation & Local Development Setup

### System Prerequisites
Ensure your local development environment meets the following specifications:
- **PHP 8.4+** with `pdo_mysql`, `mbstring`, `openssl`, `curl`, `gd`, `zip` extensions.
- **Composer 2.x**
- **Node.js 18+** & **NPM**
- **MySQL 8.0+** / MariaDB

---

### Step-by-Step Setup

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/sajusun/invozen.git
   cd invozen
   ```

2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```

3. **Install Frontend NPM Packages:**
   ```bash
   npm install
   ```

4. **Initialize Environment Configuration:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database & Stripe Keys in `.env`:**
   ```env
   APP_NAME=Invozen
   APP_ENV=local
   APP_URL=http://invozen.test

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=invozen
   DB_USERNAME=root
   DB_PASSWORD=

   # Stripe Gateway Keys
   STRIPE_KEY=pk_test_your_publishable_key
   STRIPE_SECRET=sk_test_your_secret_key
   STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
   ```

6. **Run Database Migrations & Seeds:**
   ```bash
   php artisan migrate --seed
   ```

7. **Create Storage Symbolic Link:**
   ```bash
   php artisan storage:link
   ```

8. **Start Local Development Servers:**
   ```bash
   # Terminal 1: Compile frontend assets with Vite
   npm run dev

   # Terminal 2: Start Laravel Application (or run via Laravel Herd / Valet)
   php artisan serve
   ```

---

## 🔐 Default Credentials & Seeding Matrix

Running `php artisan db:seed` provisions the following predefined platform credentials:

### 🛡️ Administrative Accounts (`/admin/login`)
| Role | Email | Password | Access Capabilities |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@gmail.com` | `password` | Full Unrestricted Root Access (`*`) |
| **System Admin** | `admin@gmail.com` | `password` | Invoices, Users, Settings, Payments, Plans |
| **Content Moderator** | `moderator@gmail.com` | `password` | Invoices & General Read Capabilities |

### 👤 Demo User Accounts (`/login`)
| Account Tier | Email | Password | Included Features |
| :--- | :--- | :--- | :--- |
| **Demo Customer** | `user@invozen.com` | `password` | Invoicing Builder, CRM, Reports, API Keys |

---

## 📡 Developer REST API Reference (V1)

Invozen features a developer-first RESTful API at `/api/v1/`.

### Authentication Header
Pass your API secret key as a Bearer token:
```http
Authorization: Bearer inv_live_sk_your_api_key_here
Accept: application/json
```

### Endpoints Matrix
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/v1/me` | Developer profile, subscription tier, and usage limits |
| `GET` | `/api/v1/invoices` | Paginated invoice list with status filtering |
| `POST` | `/api/v1/invoices` | Create a new invoice with itemized entries |
| `GET` | `/api/v1/invoices/{id}` | Retrieve individual invoice details |
| `PUT/PATCH` | `/api/v1/invoices/{id}` | Update invoice items, discounts, or metadata |
| `POST` | `/api/v1/invoices/{id}/mark-paid` | Transition invoice state to Paid |
| `GET` | `/api/v1/invoices/{id}/pdf` | Stream or download compiled PDF invoice |
| `DELETE` | `/api/v1/invoices/{id}` | Permanently delete invoice |
| `GET` | `/api/v1/customers` | Retrieve customer directory |
| `POST` | `/api/v1/customers` | Register a new client entity |

---

## ⚙️ Environment Configuration (`.env`)

| Key | Default / Recommended | Purpose |
| :--- | :--- | :--- |
| `APP_ENV` | `local` | Application runtime environment |
| `APP_DEBUG` | `true` (local) / `false` (prod) | Detailed exception debugging |
| `AUTH_GUARD` | `web` | Default authentication guard |
| `BROADCAST_CONNECTION`| `reverb` / `pusher` | Realtime broadcasting driver |
| `QUEUE_CONNECTION` | `database` / `redis` | Asynchronous job execution queue |
| `STRIPE_KEY` | `pk_test_...` | Stripe public checkout key |
| `STRIPE_SECRET` | `sk_test_...` | Stripe backend API secret |

---

## 🧪 Testing & Quality Assurance

Run the automated test suite powered by **Pest PHP**:
```bash
php artisan test
```

Perform maintenance and optimization cache refreshes:
```bash
php artisan optimize:clear
php artisan route:list
```

---

## 📜 License & Credits

The **Invozen** SaaS platform is open-sourced software licensed under the [MIT License](LICENSE).
Built with ❤️ using **PHP 8.4** & **Laravel 12**.

