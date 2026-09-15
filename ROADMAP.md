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

## 🎨 Phase 6: Reusable Tailwind Blade Component Library
- [ ] **6.1** `<x-ui.stat-card>` (Metric cards with gradients, trend badges, and icons)
- [ ] **6.2** `<x-ui.badge>` (Universal status badges: paid, unpaid, overdue, canceled, active)
- [ ] **6.3** `<x-ui.card>` (Standardized container card with headers and actions)
- [ ] **6.4** `<x-ui.quota-bar>` (Plan usage quota progress indicator)
- [ ] **6.5** `<x-ui.action-button>` (Clean reusable button variants: primary, outline, danger)

---

## 📊 Phase 7: Industry-Standard User Dashboard Transformation
- [ ] **7.1** Backend Aggregation in `DashboardController`:
  - [ ] 6-Month Monthly Revenue & Collection billing trends for Chart.js
  - [ ] Top 5 Clients by revenue volume and outstanding dues
  - [ ] Real-time Paid, Due, Overdue, and Average Invoice value metrics
  - [ ] User Plan Quota calculation (Invoices used / Plan limit, Clients used / Plan limit)
- [ ] **7.2** Modern Dashboard View (`resources/views/dashboard2.blade.php`):
  - [ ] Dynamic User & Company Greeting
  - [ ] 4 Interactive Financial Stat Cards
  - [ ] Real-time Chart.js Revenue & Invoicing Trends Chart
  - [ ] Quick Action Hub (+ Create Invoice, + Add Client, Developer API, Plans)
  - [ ] Live Recent Invoices Table with One-Click Actions (Preview, PDF, Copy Pay Link, Mark Paid)
  - [ ] Top Clients Widget with outstanding balances
  - [ ] Subscription Quota Bar & Developer API Quick Connect Widget

---

## 🛡️ Phase 8: Robust SaaS Admin Panel Architecture
- [ ] **8.1** Admin Metrics: Total Registered Users, Active Subscriptions, Platform MRR, Platform Invoices
- [ ] **8.2** Visual Platform Charts: 30-Day Registration growth & Plan Distribution (Free/Premium/Business)
- [ ] **8.3** Enhanced Users Management: Filter by plan, search, manual plan upgrade modal
- [ ] **8.4** Payment Audit Ledger: Transaction history with gateway breakdown (Stripe, PayPal, SSLCommerz)

---

*Last Updated: 2026-09-15 — Upgrading User Dashboard & Robust Admin Panel.*
