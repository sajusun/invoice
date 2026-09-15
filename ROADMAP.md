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

## 🛡️ Phase 8: Robust SaaS Admin Panel Architecture
- [x] **8.1** Admin Metrics: Total Registered Users, Active Subscriptions, Platform MRR, Platform Invoices
- [x] **8.2** Visual Platform Charts: 7-Day Registration growth & Plan Distribution (Free/Premium/Business)
- [x] **8.3** Enhanced Users Management: Filter by plan, search, manual plan upgrade modal
- [x] **8.4** Payment Audit Ledger: Transaction history with gateway breakdown (Stripe, PayPal, SSLCommerz)

---

*Last Updated: 2026-09-15 — Full Platform Modernization Completed.*
