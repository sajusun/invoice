<x-app-layout>
    <x-slot name="title">User & Developer Guides - Invozen</x-slot>

    <div class="bg-slate-50 min-h-screen pb-20" x-data="{
        activeTab: 'getting-started',
        search: '',
        matches(text) {
            if (!this.search) return true;
            return text.toLowerCase().includes(this.search.toLowerCase());
        }
    }">
        <!-- Hero Header -->
        <div class="bg-slate-900 text-white border-b border-slate-800 py-14 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-violet-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-6xl mx-auto text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-indigo-500/15 text-indigo-400 border border-indigo-500/20 mb-4">
                    <i class="fa-solid fa-book-open"></i> Invozen Documentation & Knowledge Base
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight">
                    Invozen User & Platform Guides
                </h1>
                <p class="mt-3 text-slate-400 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    Master invoice creation, client tracking, recurring automation, developer API integration, and team role management with our comprehensive step-by-step guides.
                </p>

                <!-- Search Filter Bar -->
                <div class="mt-8 max-w-xl mx-auto relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 text-sm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" x-model="search" placeholder="Search guides (e.g. recurring invoices, API keys, PDF)..."
                           class="w-full pl-11 pr-4 py-3.5 bg-slate-800/90 border border-slate-700/80 rounded-2xl text-sm text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:bg-slate-800 focus:border-indigo-500 transition outline-none shadow-xl shadow-black/20">
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Sidebar Category Nav -->
                <div class="lg:col-span-3">
                    <div class="sticky top-24 bg-white rounded-2xl p-4 border border-slate-200/80 shadow-sm space-y-1.5 text-xs font-medium">
                        <span class="block px-3 py-1.5 font-bold uppercase tracking-wider text-slate-400 text-[10px]">Guide Sections</span>

                        <button @click="activeTab = 'getting-started'"
                                :class="activeTab === 'getting-started' ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100 shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
                                class="w-full text-left px-3.5 py-2.5 rounded-xl transition flex items-center gap-2.5">
                            <i class="fa-solid fa-rocket text-indigo-500 w-4"></i>
                            <span>1. Getting Started</span>
                        </button>

                        <button @click="activeTab = 'invoicing'"
                                :class="activeTab === 'invoicing' ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100 shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
                                class="w-full text-left px-3.5 py-2.5 rounded-xl transition flex items-center gap-2.5">
                            <i class="fa-solid fa-file-invoice text-blue-500 w-4"></i>
                            <span>2. Invoice Builder & PDF</span>
                        </button>

                        <button @click="activeTab = 'clients'"
                                :class="activeTab === 'clients' ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100 shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
                                class="w-full text-left px-3.5 py-2.5 rounded-xl transition flex items-center gap-2.5">
                            <i class="fa-solid fa-users text-emerald-500 w-4"></i>
                            <span>3. Client Directory</span>
                        </button>

                        <button @click="activeTab = 'recurring'"
                                :class="activeTab === 'recurring' ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100 shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
                                class="w-full text-left px-3.5 py-2.5 rounded-xl transition flex items-center gap-2.5">
                            <i class="fa-solid fa-rotate text-purple-500 w-4"></i>
                            <span>4. Recurring & Schedulers</span>
                        </button>

                        <button @click="activeTab = 'api'"
                                :class="activeTab === 'api' ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100 shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
                                class="w-full text-left px-3.5 py-2.5 rounded-xl transition flex items-center gap-2.5">
                            <i class="fa-solid fa-code text-cyan-500 w-4"></i>
                            <span>5. Developer API & Webhooks</span>
                        </button>

                        <button @click="activeTab = 'acl'"
                                :class="activeTab === 'acl' ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100 shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
                                class="w-full text-left px-3.5 py-2.5 rounded-xl transition flex items-center gap-2.5">
                            <i class="fa-solid fa-shield-halved text-rose-500 w-4"></i>
                            <span>6. Team Roles & ACL</span>
                        </button>

                        <div class="pt-4 border-t border-slate-100 mt-3">
                            <a href="{{ route('api-docs') }}" class="block px-3.5 py-2 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 rounded-xl transition text-center">
                                View API Reference →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content Panel -->
                <div class="lg:col-span-9 space-y-8">

                    <!-- SECTION 1: GETTING STARTED -->
                    <div x-show="activeTab === 'getting-started'" class="space-y-6">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-rocket"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Getting Started with Invozen</h2>
                                    <p class="text-xs sm:text-sm text-slate-500">Configure your business identity and start issuing professional invoices in minutes.</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-slate-700 text-sm leading-relaxed">
                                <h3 class="font-bold text-base text-slate-900 flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center font-mono">1</span>
                                    Account Setup & Company Profile
                                </h3>
                                <p>
                                    After signing up, visit <a href="{{ route('settings.edit') }}" class="font-semibold text-indigo-600 hover:underline">Settings</a> to configure your business branding. This information is automatically placed on all generated PDFs and invoice emails:
                                </p>
                                <ul class="list-disc list-inside space-y-1 pl-2 text-slate-600 text-xs sm:text-sm">
                                    <li><strong>Company Name & Logo:</strong> Upload high-resolution branding image.</li>
                                    <li><strong>Invoice Number Prefix:</strong> Set your prefix format (e.g. <code class="bg-slate-100 px-1.5 py-0.5 rounded text-indigo-600">INV-2026-</code>).</li>
                                    <li><strong>Tax / VAT Identification:</strong> Automatically printed on client receipts.</li>
                                    <li><strong>Default Currency:</strong> Choose from USD ($), EUR (€), GBP (£), BDT (৳), and 30+ supported currencies.</li>
                                    <li><strong>Default Terms & Notes:</strong> Pre-fill bank account instructions and payment terms.</li>
                                </ul>

                                <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-4 text-xs sm:text-sm text-indigo-900 flex items-start gap-3">
                                    <i class="fa-solid fa-lightbulb text-indigo-600 text-base mt-0.5"></i>
                                    <div>
                                        <strong>Pro Tip:</strong> You can create and preview guest invoices anytime using the <a href="{{ route('invoice.builder') }}" class="underline font-semibold">Free Invoice Builder</a> without logging in!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: INVOICING & PDF -->
                    <div x-show="activeTab === 'invoicing'" class="space-y-6">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Creating & Customizing Invoices</h2>
                                    <p class="text-xs sm:text-sm text-slate-500">How to create, edit, calculate totals, duplicate, and export invoices as PDFs.</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-slate-700 text-sm leading-relaxed">
                                <h3 class="font-bold text-base text-slate-900">1. Line Item Calculations & Discounts</h3>
                                <p>
                                    The Invozen builder automatically calculates real-time line totals (<code class="bg-slate-100 px-1.5 py-0.5 rounded font-mono">Qty × Rate</code>). You can configure:
                                </p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                        <div class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-1">Percentage or Fixed Discounts</div>
                                        <p class="text-xs text-slate-600">Apply flat dollar amounts or percentage discounts that adjust subtotal and tax amounts dynamically.</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                        <div class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-1">Flexible Tax Rates</div>
                                        <p class="text-xs text-slate-600">Set custom tax percentages per invoice or disable taxes when billing international clients.</p>
                                    </div>
                                </div>

                                <h3 class="font-bold text-base text-slate-900 pt-3">2. 1-Click Invoice Actions</h3>
                                <p>From the <a href="{{ route('invoices') }}" class="font-semibold text-indigo-600 hover:underline">Invoices List</a>, you have instant access to key operations:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <strong class="text-slate-900 block mb-1"><i class="fa-solid fa-paper-plane text-blue-500 mr-1"></i> Send Email</strong>
                                        Dispatches a branded HTML email with dynamic PDF attached directly to the client's inbox.
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <strong class="text-slate-900 block mb-1"><i class="fa-solid fa-copy text-purple-500 mr-1"></i> Duplicate</strong>
                                        Clones all items and customer details into a new draft with a freshly generated invoice number.
                                    </div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                        <strong class="text-slate-900 block mb-1"><i class="fa-solid fa-file-pdf text-rose-500 mr-1"></i> PDF Export</strong>
                                        Generates pixel-perfect binary PDF documents ready for printing or archiving.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: CLIENT MANAGEMENT -->
                    <div x-show="activeTab === 'clients'" class="space-y-6">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Client Directory & Financial Metrics</h2>
                                    <p class="text-xs sm:text-sm text-slate-500">Track client balances, contact information, and billing histories.</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-slate-700 text-sm leading-relaxed">
                                <p>
                                    Managing your client base in Invozen automatically synchronizes contacts with your invoices. When adding a customer, you can store:
                                </p>
                                <ul class="list-disc list-inside space-y-1 pl-2 text-slate-600 text-xs sm:text-sm">
                                    <li><strong>Primary Contact & Company:</strong> Client name, business/company name, and tax ID.</li>
                                    <li><strong>Billing Address & Contacts:</strong> Email and phone for auto-populated invoice templates.</li>
                                    <li><strong>Financial Dashboard:</strong> View total revenue collected, active pending invoices, and outstanding due balance per client.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: RECURRING BILLING -->
                    <div x-show="activeTab === 'recurring'" class="space-y-6">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-rotate"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Recurring Billing & Schedulers</h2>
                                    <p class="text-xs sm:text-sm text-slate-500">Automate recurring client retainers and automated overdue status transitions.</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-slate-700 text-sm leading-relaxed">
                                <h3 class="font-bold text-base text-slate-900">1. Setting up a Recurring Invoice</h3>
                                <p>
                                    When creating or editing an invoice, check <span class="font-semibold text-indigo-600">Recurring Schedule</span> and select your preferred frequency:
                                </p>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs font-semibold">
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800">Weekly</div>
                                    <div class="p-3 bg-indigo-50 rounded-xl border border-indigo-200 text-indigo-700">Monthly</div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800">Quarterly</div>
                                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800">Yearly</div>
                                </div>

                                <h3 class="font-bold text-base text-slate-900 pt-3">2. Automation Artisan Commands</h3>
                                <p>The system runs background schedulers automatically:</p>
                                <div class="space-y-2 font-mono text-xs">
                                    <div class="bg-slate-900 text-slate-100 p-3 rounded-xl">
                                        <span class="text-emerald-400"># Auto-generate scheduled invoices</span><br>
                                        php artisan invoices:generate-recurring
                                    </div>
                                    <div class="bg-slate-900 text-slate-100 p-3 rounded-xl">
                                        <span class="text-emerald-400"># Scan & mark past-due invoices as overdue</span><br>
                                        php artisan invoices:mark-overdue
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 5: DEVELOPER API -->
                    <div x-show="activeTab === 'api'" class="space-y-6">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-code"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Developer REST API & Webhooks</h2>
                                    <p class="text-xs sm:text-sm text-slate-500">Integrate programmatic invoicing into your applications, SaaS, and eCommerce checkouts.</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-slate-700 text-sm leading-relaxed">
                                <p>
                                    Invozen provides a full Invoicing-as-a-Service RESTful API authenticated via secret Bearer tokens.
                                </p>

                                <div class="bg-slate-900 text-slate-100 p-4 rounded-2xl font-mono text-xs overflow-x-auto">
                                    <span class="text-slate-400">// Sample cURL API Request</span><br>
                                    curl -X POST {{ config('app.url') }}/api/v1/invoices \<br>
                                    &nbsp;&nbsp;-H "Authorization: Bearer inv_live_sk_your_api_key" \<br>
                                    &nbsp;&nbsp;-H "Content-Type: application/json" \<br>
                                    &nbsp;&nbsp;-d '{"customer":{"name":"Acme Corp","email":"billing@acme.com"},"items":[{"name":"Consulting","qty":1,"rate":500}]}'
                                </div>

                                <div class="pt-2">
                                    <a href="{{ route('api-docs') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md transition">
                                        <i class="fa-solid fa-book"></i> Open Full Interactive API Docs
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 6: TEAM ROLES & ACL -->
                    <div x-show="activeTab === 'acl'" class="space-y-6">
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Role-Based Access Control (ACL)</h2>
                                    <p class="text-xs sm:text-sm text-slate-500">Plug & Play granular permissions, team roles, and middleware security.</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-slate-700 text-sm leading-relaxed">
                                <p>
                                    Invozen includes an enterprise-grade ACL module providing role verification, prefix wildcards (e.g. <code class="bg-slate-100 px-1.5 py-0.5 rounded text-indigo-600">invoices.*</code>), request-level memoization, and expressive Blade directives:
                                </p>
                                <div class="bg-slate-900 text-slate-100 p-4 rounded-2xl font-mono text-xs">
                                    @role('admin')<br>
                                    &nbsp;&nbsp;&lt;button&gt;Admin Actions&lt;/button&gt;<br>
                                    @endrole<br><br>
                                    @permission('invoices.create')<br>
                                    &nbsp;&nbsp;&lt;a href="/invoice/builder"&gt;New Invoice&lt;/a&gt;<br>
                                    @endpermission
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
