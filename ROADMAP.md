# 🗺️ Invozen SaaS & Developer Microservice Roadmap

> **Status Tracking Document**: Completed tasks are marked with `[x]`, and pending tasks are marked with `[ ]`. If work is paused, it will resume from the first pending checkbox.

---

## 📌 Phase 1: Architecture & Clean Modular Separation
- [x] **1.1** Reorganize Controllers into namespaces:
  - [x] `App\Http\Controllers\Admin\` (Platform Administration)
  - [x] `App\Http\Controllers\Api\V1\` (Developer RESTful API)
  - [x] `App\Http\Controllers\` (User Web Portal & Blade views)
- [x] **1.2** Clean Route Architecture:
  - [x] `routes/web.php` (Frontend & User Dashboard)
  - [x] `routes/admin.php` & `routes/admin_routes.php` (Admin Panel)
  - [x] `routes/api.php` (Developer V1 API)
- [x] **1.3** Service Layer Setup:
  - [x] `App\Services\InvoiceService`
  - [x] `App\Services\ApiKeyService`
  - [x] `App\Services\WebhookDispatcherService`

---

## 🔑 Phase 2: Developer API & Secret Key Infrastructure
- [x] **2.1** Migration & Model for `api_keys` (`public_key`, `secret_key_hash`, `scopes`, `expires_at`, `is_active`)
- [x] **2.2** `ApiKeyService` (Key generation `inv_live_pk_...` / `inv_live_sk_...`, hashing & validation)
- [x] **2.3** Authentication Middleware `AuthenticateApiKey` supporting `Bearer inv_live_sk_...` & `X-API-KEY`
- [x] **2.4** Rate Limiting (`throttle:120,1`) & Plan Limit enforcement on API calls

---

## ⚡ Phase 3: Core V1 RESTful API Endpoints
- [x] **3.1** Form Requests & API Resources (`CreateInvoiceRequest`, `CreateCustomerRequest`, `InvoiceResource`, `CustomerResource`, `UserResource`)
- [x] **3.2** `GET /api/v1/me` (Developer profile & plan usage limits)
- [x] **3.3** `POST /api/v1/invoices` (Create invoice with inline/existing customer & item arrays)
- [x] **3.4** `GET /api/v1/invoices` (List, search, filter, and pagination)
- [x] **3.5** `GET /api/v1/invoices/{id}` & `GET /api/v1/invoices/{id}/pdf`
- [x] **3.6** `POST /api/v1/invoices/{id}/mark-paid` (Mark as paid/update status)
- [x] **3.7** `DELETE /api/v1/invoices/{id}` (Delete invoice)
- [x] **3.8** `GET /api/v1/customers`, `POST /api/v1/customers`, `GET /api/v1/customers/{id}`, `DELETE /api/v1/customers/{id}`

---

## 💻 Phase 4: User Dashboard API Key UI & Interactive Docs
- [x] **4.1** User Dashboard UI: API Keys Management page (`/dashboard/developer/api-keys`)
  - Create new keys with one-time copy modal
  - Active keys listing, scopes, and revoke button
  - Webhooks destination endpoint registration
- [x] **4.2** Interactive Developer API Documentation (`/api-docs` / `/developer/docs`) with cURL, PHP, JS, and Python examples

---

## 🔗 Phase 5: Webhooks & Event Dispatching
- [x] **5.1** Migration & Model for `webhook_endpoints`
- [x] **5.2** `WebhookDispatcherService` with HMAC-SHA256 signature verification (`X-Invozen-Signature`)
- [x] **5.3** Dispatch webhooks on `invoice.created` and `invoice.paid`

---

## 🎨 Phase 6: Reusable Tailwind Blade Component Library
- [x] **6.1** `<x-ui.stat-card>` (Metric cards with gradients, trend badges, and icons)
- [x] **6.2** `<x-ui.badge>` (Universal status badges: paid, unpaid, overdue, canceled, active)
- [x] **6.3** `<x-ui.card>` (Standardized container card with headers and actions)
- [x] **6.4** `<x-ui.quota-bar>` (Plan usage quota progress indicator)
- [x] **6.5** `<x-ui.action-button>` (Clean reusable button variants: primary, outline, danger)

---

## 📊 Phase 7: Industry-Standard User Dashboard Transformation
- [x] **7.1** Backend Aggregation in `DashboardController`:
  - [x] 6-Month Monthly Revenue & Collection billing trends for Chart.js
  - [x] Top 5 Clients by revenue volume and outstanding dues
  - [x] Real-time Paid, Due, Overdue, and Average Invoice value metrics
  - [x] User Plan Quota calculation (Invoices used / Plan limit, Clients used / Plan limit)
- [x] **7.2** Modern Dashboard View (`resources/views/dashboard2.blade.php`):
  - [x] Dynamic User & Company Greeting
  - [x] 4 Interactive Financial Stat Cards
  - [x] Real-time Chart.js Revenue & Invoicing Trends Chart
  - [x] Quick Action Hub (+ Create Invoice, + Add Client, Developer API, Plans)
  - [x] Live Recent Invoices Table with One-Click Actions (Preview, PDF, Copy Pay Link, Mark Paid)
  - [x] Top Clients Widget with outstanding balances
  - [x] Subscription Quota Bar & Developer API Quick Connect Widget

---

---

## 🎨 Phase 9: Global User Layout & Aesthetic Architecture
- [x] **9.1** Modern Color Palette & Full-Height Shell:
  - [x] Refined Slate theme (`bg-slate-50/60`, `text-slate-800`, Google Font Plus Jakarta Sans)
  - [x] Replaced restrictive boxed grid with responsive sticky sidebar + header layout
- [x] **9.2** Upgraded Sidebar Component (`custom-components/dashboard-aside.blade.php`):
  - [x] Dynamic route highlighting (`request()->routeIs(...)`) with subtle accent borders
  - [x] Modern brand logo badge & categorized navigation (Main, Financial, Developer & Settings)
  - [x] Bottom user plan status card with fast logout
- [x] **9.3** Top Header & Notifications (`custom-components/dashboard-header.blade.php` & `user_auth_or_not.blade.php`):
  - [x] Global quick search bar with `⌘K` shortcut appearance
  - [x] Quick "+ New" action button for creating invoices and clients
  - [x] Polished notifications dropdown and user profile avatar menu
- [x] **9.4** Mobile Experience & Drawer:
  - [x] Smooth slide-over navigation drawer with backdrop blur and touch dismiss

---

## 🛡️ Phase 10: Admin Panel Isolation & Invoice Builder Overhaul
- [x] **10.1** Fail-Safe User Dropdown Engine:
  - [x] Resolved Reverb/Echo unhandled promise exception in `echo.js` and uncommented Vite Reverb env keys.
  - [x] Added `pointer-events-none` on inner elements of dropdown buttons to ensure clean click target resolution.
  - [x] Streamlined Alpine.js `@click` and `@click.outside` directives across user and admin headers.
- [x] **10.2** Complete Admin Panel Isolation & Dedicated Layout:
  - [x] Dedicated dark-slate SaaS Admin theme (`layouts/admin.blade.php`, `custom-components/admin-dashboard-aside.blade.php`)
  - [x] Strict separation with `auth:admin` guard and dedicated admin navbar (`components/admin-navbar.blade.php`)
  - [x] Dynamic admin route highlighting, role badges, and isolated admin sign-out
- [x] **10.3** Invoice Creation Studio & Backend Engine:
  - [x] Upgraded Vue 3 Invoice Builder component (`builder.vue`) with multi-currency, auto-tax, and instant status toasts
  - [x] Rebuilt `InvoicesController::makeInvoice()` to save client, create invoice, calculate line items, and dispatch webhooks

---

## 💎 Phase 11: Enterprise Admin Pages & Permission Control UI
- [x] **11.1** Granular Role Permissions Matrix (`/admin/dashboard/roles`):
  - [x] Modern Enterprise matrix table with feature tags, clean checkboxes, and SuperAdmin lock
  - [x] Administrator directory table with instant role reassignment dropdown and actions
  - [x] Add New Admin form (`/admin/dashboard/users/create`) & Edit Admin form (`/admin/dashboard/users/{id}/edit`)
- [x] **11.2** Admin Security Profile (`/admin/profile`):
  - [x] Admin hero banner, live avatar preview, and profile photo upload handling in `AdminProfileController`
  - [x] Password change and credentials update with validation feedback
- [x] **11.3** Platform Revenue & Payments Audit (`/admin/dashboard/payments`):
  - [x] Revenue stat cards, transactions list, plan badges, and gateway badges with full pagination
  - [x] Custom/Manual Subscription assignment studio (`/admin/dashboard/payments/create`)
  - [x] Comprehensive User Inspector (`/admin/dashboard/user-info/{id}`) integrated with `<x-admin-layout>`

---

*Last Updated: 2026-09-15 — Full Platform, Navbar Dropdown Fix & Enterprise Admin Pages Overhaul Completed.*


