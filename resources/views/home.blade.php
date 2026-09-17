<x-home-layout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-slate-50 via-indigo-50/20 to-white">
        <!-- Subtle Glow Background Elements -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-indigo-200/40 to-violet-200/30 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute top-1/2 right-10 w-[300px] h-[300px] bg-cyan-200/30 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 text-center lg:text-left">
                    <!-- Pill Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-indigo-100 shadow-sm mb-6 hover:border-indigo-200 transition-colors">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-700">PHP 8.4 & Laravel 12 Ready</span>
                        <span class="text-slate-300">|</span>
                        <span class="text-xs font-medium text-slate-600">Universal Invoicing Microservice</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-6">
                        The Invoicing Infrastructure for <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Modern Teams & APIs</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 font-normal leading-relaxed mb-8 max-w-2xl mx-auto lg:mx-0">
                        Create invoices in seconds through an intuitive studio or integrate our high-performance RESTful API into your applications with arbitrary metadata, webhooks, and auto-generated PDFs.
                    </p>

                    <!-- Dual CTAs -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center">
                        <a href="{{ route('invoice.builder') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5 hover:shadow-xl">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                            <span>Create Live Invoice</span>
                        </a>
                        <a href="{{ route('api-docs') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-bold text-base border border-slate-200 shadow-sm transition-all hover:border-slate-300">
                            <i class="fa-solid fa-code text-indigo-600"></i>
                            <span>Developer API Docs</span>
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="mt-12 pt-8 border-t border-slate-200/60 grid grid-cols-3 gap-6 text-center lg:text-left">
                        <div>
                            <div class="text-2xl lg:text-3xl font-black text-slate-900">0.05s</div>
                            <div class="text-xs font-medium text-slate-500 mt-1">Cursor Paging Speed</div>
                        </div>
                        <div>
                            <div class="text-2xl lg:text-3xl font-black text-slate-900">JSON</div>
                            <div class="text-xs font-medium text-slate-500 mt-1">Arbitrary Metadata</div>
                        </div>
                        <div>
                            <div class="text-2xl lg:text-3xl font-black text-slate-900">100%</div>
                            <div class="text-xs font-medium text-slate-500 mt-1">Automated PDF & HMAC</div>
                        </div>
                    </div>
                </div>

                <!-- Right Hero: Interactive Glassmorphic Live Invoice Showcase -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md rounded-3xl bg-white/95 p-6 shadow-2xl shadow-indigo-500/10 border border-slate-200/80 backdrop-blur-xl">
                        <!-- Invoice Card Header -->
                        <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-base shadow-sm">
                                    ⚡
                                </div>
                                <div>
                                    <div class="font-extrabold text-slate-900 text-sm">Acme Software Inc.</div>
                                    <div class="text-[11px] text-slate-400">INV-2026-08892</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Paid in Full
                            </span>
                        </div>

                        <!-- Client & Metadata Info -->
                        <div class="py-4 grid grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block mb-0.5">Billed To</span>
                                <span class="font-bold text-slate-800 block">Apex Technologies</span>
                                <span class="text-slate-500 text-[11px]">billing@apextech.io</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block mb-0.5">Issue Date</span>
                                <span class="font-bold text-slate-800 block">{{ date('M d, Y') }}</span>
                                <span class="text-slate-500 text-[11px]">Due on receipt</span>
                            </div>
                        </div>

                        <!-- Live Line Items -->
                        <div class="bg-slate-50/80 rounded-2xl p-3 border border-slate-100 space-y-2 mb-4">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-semibold text-slate-800">Enterprise Cloud Subscription</span>
                                <span class="font-bold text-slate-900">$2,400.00</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-semibold text-slate-800">Dedicated SLA Support (1 mo)</span>
                                <span class="font-bold text-slate-900">$500.00</span>
                            </div>
                            <div class="pt-2 border-t border-slate-200/60 flex justify-between items-center">
                                <span class="text-xs font-bold text-slate-600">Total Billed</span>
                                <span class="text-base font-black text-indigo-600">$2,900.00</span>
                            </div>
                        </div>

                        <!-- Arbitrary Metadata Feature Callout -->
                        <div class="rounded-xl bg-violet-50/80 border border-violet-100 p-3 mb-4">
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="font-bold text-violet-800 flex items-center gap-1">
                                    <i class="fa-solid fa-code"></i> Developer Metadata
                                </span>
                                <span class="text-[10px] text-violet-600 bg-white px-1.5 py-0.5 rounded font-mono">JSON</span>
                            </div>
                            <div class="font-mono text-[10px] text-violet-700 bg-white/70 p-2 rounded-lg border border-violet-100/60">
                                {"order_id": "SHOP-7712", "crm_lead": "L-904", "auto_sync": true}
                            </div>
                        </div>

                        <!-- Quick Actions Hub -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('invoice.builder') }}" class="text-center py-2.5 px-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Try Studio
                            </a>
                            <a href="{{ route('api-docs') }}" class="text-center py-2.5 px-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition-all border border-indigo-100">
                                <i class="fa-solid fa-terminal mr-1"></i> View Payload
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Developer Microservice Section (Interactive Code Showcase) -->
    <section id="developers" class="py-20 bg-slate-900 text-white relative overflow-hidden" x-data="{ activeTab: 'curl' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-400 border border-indigo-500/30">
                    Developer-First Microservice
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4 mb-4 tracking-tight">
                    Integrate Invoicing into Any App in Minutes
                </h2>
                <p class="text-base sm:text-lg text-slate-400">
                    Whether you are building an e-commerce platform, SaaS app, mobile app, or internal billing script, Invozen provides clean, idempotency-safe REST endpoints with metadata support.
                </p>
            </div>

            <!-- Code Window Container -->
            <div class="max-w-4xl mx-auto bg-slate-950 rounded-2xl border border-slate-800 shadow-2xl overflow-hidden">
                <!-- Code Window Tabs Header -->
                <div class="flex items-center justify-between px-4 py-3 bg-slate-900/90 border-b border-slate-800">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500/80 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-500/80 inline-block"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500/80 inline-block"></span>
                        <span class="text-xs text-slate-500 font-mono ml-2">POST /api/v1/invoices</span>
                    </div>

                    <!-- Language Switcher Tabs -->
                    <div class="flex items-center gap-1 bg-slate-950 p-1 rounded-xl border border-slate-800 text-xs">
                        <button @click="activeTab = 'curl'" :class="activeTab === 'curl' ? 'bg-indigo-600 text-white font-bold' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1 rounded-lg transition-colors">
                            cURL
                        </button>
                        <button @click="activeTab = 'php'" :class="activeTab === 'php' ? 'bg-indigo-600 text-white font-bold' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1 rounded-lg transition-colors">
                            PHP (Laravel)
                        </button>
                        <button @click="activeTab = 'node'" :class="activeTab === 'node' ? 'bg-indigo-600 text-white font-bold' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1 rounded-lg transition-colors">
                            Node.js
                        </button>
                        <button @click="activeTab = 'python'" :class="activeTab === 'python' ? 'bg-indigo-600 text-white font-bold' : 'text-slate-400 hover:text-slate-200'" class="px-3 py-1 rounded-lg transition-colors">
                            Python
                        </button>
                    </div>
                </div>

                <!-- Code Previews -->
                <div class="p-6 font-mono text-xs sm:text-sm text-slate-300 overflow-x-auto leading-relaxed">
                    <!-- cURL Tab -->
                    <div x-show="activeTab === 'curl'">
<pre class="text-emerald-400">curl -X POST https://invozen.test/api/v1/invoices \
  -H "Authorization: Bearer inv_live_sk_your_secret_key" \
  -H "Content-Type: application/json" \
  -d '{
    "customer": {
      "name": "Wayne Enterprises",
      "email": "bruce@wayne.com",
      "phone": "+15551234",
      "metadata": { "department": "R&D" }
    },
    "items": [
      { "name": "Custom Hardware Design", "qty": 1, "rate": 5000 }
    ],
    "tax_percentage": 10,
    "metadata": {
      "ecommerce_order_id": "ORD-9988",
      "client_project_code": "PROJ-BAT"
    }
  }'</pre>
                    </div>

                    <!-- PHP Tab -->
                    <div x-show="activeTab === 'php'" style="display: none;">
<pre class="text-sky-300">use Illuminate\Support\Facades\Http;

$response = Http::withToken('inv_live_sk_your_secret_key')
    ->post('https://invozen.test/api/v1/invoices', [
        'customer' => [
            'name'  => 'Wayne Enterprises',
            'email' => 'bruce@wayne.com',
            'phone' => '+15551234',
        ],
        'items' => [
            ['name' => 'Custom Hardware Design', 'qty' => 1, 'rate' => 5000],
        ],
        'tax_percentage' => 10,
        'metadata' => [
            'ecommerce_order_id' => 'ORD-9988',
        ],
    ]);

$invoice = $response->json('data');
// $invoice['public_url'] -> Shareable public link
// $invoice['pdf_url']    -> Auto-generated PDF download link</pre>
                    </div>

                    <!-- Node.js Tab -->
                    <div x-show="activeTab === 'node'" style="display: none;">
<pre class="text-amber-300">const response = await fetch('https://invozen.test/api/v1/invoices', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer inv_live_sk_your_secret_key',
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    customer: { name: 'Wayne Enterprises', email: 'bruce@wayne.com', phone: '+15551234' },
    items: [{ name: 'Custom Hardware Design', qty: 1, rate: 5000 }],
    metadata: { ecommerce_order_id: 'ORD-9988' }
  })
});

const { data } = await response.json();
console.log('Invoice Created:', data.invoice_number, data.public_url);</pre>
                    </div>

                    <!-- Python Tab -->
                    <div x-show="activeTab === 'python'" style="display: none;">
<pre class="text-indigo-300">import requests

payload = {
    "customer": {"name": "Wayne Enterprises", "email": "bruce@wayne.com", "phone": "+15551234"},
    "items": [{"name": "Custom Hardware Design", "qty": 1, "rate": 5000}],
    "metadata": {"ecommerce_order_id": "ORD-9988"}
}

res = requests.post(
    "https://invozen.test/api/v1/invoices",
    json=payload,
    headers={"Authorization": "Bearer inv_live_sk_your_secret_key"}
)
print("Created invoice:", res.json()["data"]["invoice_number"])</pre>
                    </div>
                </div>

                <!-- Footer Bar -->
                <div class="px-6 py-3 bg-slate-900/60 border-t border-slate-800/80 flex flex-wrap items-center justify-between text-xs text-slate-400">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-bolt text-emerald-400"></i> Cursor Pagination</span>
                        <span class="flex items-center gap-1.5"><i class="fa-solid fa-lock text-indigo-400"></i> HMAC-SHA256 Webhooks</span>
                    </div>
                    <a href="{{ route('api-docs') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center gap-1">
                        Read full API reference <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Grid -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                    Enterprise Capability
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 mb-4 tracking-tight">
                    Everything You Need to Scale Your Billing
                </h2>
                <p class="text-base sm:text-lg text-slate-600">
                    Architected for high throughput, data integrity, and extreme developer flexibility.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1: Cursor Pagination -->
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white text-2xl shadow-md shadow-indigo-200 mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2.5">Dynamic Cursor Pagination</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        $O(1)$ constant-time data lookups. No skipped records or duplicates during concurrent transactions, perfectly suited for heavy APIs and infinite-scroll views.
                    </p>
                </div>

                <!-- Feature 2: Custom Metadata -->
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-violet-600 flex items-center justify-center text-white text-2xl shadow-md shadow-violet-200 mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2.5">Arbitrary JSON Metadata</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Attach custom fields (Order IDs, CRM keys, tax exemptions) directly to both Invoices and Customers without needing database migrations.
                    </p>
                </div>

                <!-- Feature 3: Webhooks & Events -->
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600 flex items-center justify-center text-white text-2xl shadow-md shadow-emerald-200 mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-satellite-dish"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2.5">Real-Time Webhooks</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Receive instant HTTP notifications on <code class="text-xs bg-slate-200 px-1 py-0.5 rounded text-slate-800">invoice.created</code> and <code class="text-xs bg-slate-200 px-1 py-0.5 rounded text-slate-800">invoice.paid</code> signed with HMAC-SHA256 headers.
                    </p>
                </div>

                <!-- Feature 4: PDF Generation -->
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-rose-600 flex items-center justify-center text-white text-2xl shadow-md shadow-rose-200 mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2.5">Automated PDF Engine</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Generate branded, publication-quality A4 PDFs on the fly for download or automated email delivery via DomPDF.
                    </p>
                </div>

                <!-- Feature 5: Customer Directory CRM -->
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 flex items-center justify-center text-white text-2xl shadow-md shadow-amber-200 mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-address-book"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2.5">Customer & Balance CRM</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Track historical customer revenues, outstanding balances, payment trends, and contact profiles in one unified view.
                    </p>
                </div>

                <!-- Feature 6: Multi-Tenant & Security -->
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white border border-slate-200/80 hover:border-indigo-200 transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-600 flex items-center justify-center text-white text-2xl shadow-md shadow-cyan-200 mb-6 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2.5">Strict Tenant Isolation</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Every invoice, client, and API key is rigorously scoped by user ownership, with optional public hash links to avoid sequential ID scraping.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 bg-slate-50 border-t border-slate-200/60" x-data="{ billing: 'monthly' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                    <i class="fa-solid fa-sparkles text-[10px] mr-1"></i> Transparent Pricing
                </span>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mt-4 mb-4 tracking-tight">
                    Simple Plans for Every Stage of Growth
                </h2>
                <p class="text-base sm:text-lg text-slate-600">
                    No hidden fees. Switch between monthly or annual billing anytime to save 20%.
                </p>

                <!-- Billing Toggle -->
                <div class="mt-8 inline-flex items-center gap-1.5 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm">
                    <button @click="billing = 'monthly'"
                            :class="billing === 'monthly' ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200">
                        Monthly Billing
                    </button>
                    <button @click="billing = 'annual'"
                            :class="billing === 'annual' ? 'bg-indigo-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center gap-2">
                        <span>Annual Billing</span>
                        <span class="text-[10px] font-extrabold bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full shadow-xs">
                            Save 20%
                        </span>
                    </button>
                </div>
            </div>

            <!-- Pricing Cards Grid -->
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
                @forelse($plans ?? [] as $plan)
                    @php
                        $isFeatured = (bool) $plan->is_popular || strtolower($plan->type) === 'premium' || $loop->iteration == 2;
                        $isBusiness = strtolower($plan->type) === 'business' || $loop->iteration == 3;
                    @endphp

                    <div class="flex flex-col justify-between p-8 sm:p-9 rounded-3xl bg-white border transition-all duration-300 relative
                        {{ $isFeatured ? 'border-indigo-600 ring-4 ring-indigo-50 shadow-2xl shadow-indigo-100/60 z-10' : 'border-slate-200 shadow-md hover:shadow-lg' }}">
                        
                        @if($isFeatured)
                            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-[11px] font-bold uppercase tracking-wider shadow-md">
                                Most Popular
                            </div>
                        @endif

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-2xl font-extrabold text-slate-900">{{ $plan->name }}</h3>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    @if($isFeatured) bg-indigo-50 text-indigo-700 border border-indigo-100
                                    @elseif($isBusiness) bg-purple-50 text-purple-700 border border-purple-100
                                    @else bg-slate-100 text-slate-700 @endif">
                                    {{ ucfirst($plan->slug ?? $plan->type) }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 mb-6 min-h-[36px] leading-relaxed">
                                {{ $plan->description ?? 'Ideal for growing businesses and agencies needing reliable invoicing.' }}
                            </p>

                            <!-- Dynamic Price Display -->
                            <div class="mb-6 pb-6 border-b border-slate-100 min-h-[96px] flex flex-col justify-center">
                                @if($plan->monthly_price == 0)
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono">$0</span>
                                        <span class="text-sm font-semibold text-slate-500">/ month</span>
                                    </div>
                                    <span class="text-xs font-medium text-emerald-600 mt-1">Free forever. No credit card required.</span>
                                @else
                                    <!-- Monthly Price View -->
                                    <div x-show="billing === 'monthly'" class="space-y-1">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono">
                                                ${{ number_format($plan->monthly_price, 0) }}
                                            </span>
                                            <span class="text-sm font-semibold text-slate-500">/ month</span>
                                        </div>
                                        <span class="text-xs font-medium text-slate-400 block">Billed monthly. Cancel anytime.</span>
                                    </div>

                                    <!-- Annual Price View -->
                                    <div x-show="billing === 'annual'" class="space-y-1" style="display: none;">
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight font-mono text-indigo-600">
                                                ${{ number_format($plan->annual_monthly_equivalent, 0) }}
                                            </span>
                                            <span class="text-sm font-semibold text-slate-500">/ mo</span>
                                            <span class="text-sm font-semibold text-slate-400 line-through">
                                                ${{ number_format($plan->monthly_price, 0) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                                            <i class="fa-solid fa-tag text-[10px]"></i>
                                            <span>Billed ${{ number_format($plan->annual_price, 0) }}/yr (Save ${{ number_format($plan->annual_savings, 0) }})</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Features List -->
                            <div class="mb-8">
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-3.5">What's included:</span>
                                <ul class="space-y-3 text-xs text-slate-600">
                                    @if($plan->features && is_array($plan->features))
                                        @foreach($plan->features as $feat)
                                            <li class="flex items-center gap-2.5">
                                                <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                    <i class="fa-solid fa-check text-[9px]"></i>
                                                </div>
                                                <span class="leading-relaxed">{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="flex items-center gap-2.5">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                            </div>
                                            <span><strong>{{ $plan->max_invoices ? number_format($plan->max_invoices) : 'Unlimited' }}</strong> Invoices / month</span>
                                        </li>
                                        <li class="flex items-center gap-2.5">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                            </div>
                                            <span><strong>{{ $plan->max_customers ? number_format($plan->max_customers) : 'Unlimited' }}</strong> Client Directory storage</span>
                                        </li>
                                        <li class="flex items-center gap-2.5">
                                            <div class="w-4 h-4 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-check text-[9px]"></i>
                                            </div>
                                            <span>RESTful Developer API & Webhooks</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div>
                            @auth
                                @if($plan->monthly_price == 0)
                                    <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition-all">
                                        Current Base Plan
                                    </a>
                                @else
                                    <a :href="'{{ url('/checkout') }}/{{ $plan->id }}?cycle=' + billing"
                                       class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl font-bold text-xs transition-all shadow-md
                                       {{ $isFeatured ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-indigo-200' : 'bg-slate-900 hover:bg-slate-800 text-white' }}">
                                        Upgrade to {{ $plan->name }}
                                        <i class="fa-solid fa-arrow-right text-[10px] ml-1.5"></i>
                                    </a>
                                @endif
                            @else
                                <a :href="'{{ route('register') }}?plan={{ $plan->slug ?? $plan->type }}&cycle=' + billing"
                                   class="w-full inline-flex items-center justify-center py-3.5 px-4 rounded-xl font-bold text-xs transition-all shadow-md
                                   {{ $isFeatured ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-indigo-200' : 'bg-slate-900 hover:bg-slate-800 text-white' }}">
                                    Get Started
                                    <i class="fa-solid fa-arrow-right text-[10px] ml-1.5"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-400">
                        No pricing plans found. Please seed the database.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-white" x-data="{ openFaq: null }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                    Frequently Asked Questions
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 mb-4 tracking-tight">
                    Everything You Need to Know
                </h2>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5 cursor-pointer" @click="openFaq = openFaq === 1 ? null : 1">
                    <div class="flex items-center justify-between font-bold text-slate-900 text-base">
                        <span>How does the arbitrary JSON metadata work?</span>
                        <i class="fa-solid" :class="openFaq === 1 ? 'fa-chevron-up text-indigo-600' : 'fa-chevron-down text-slate-400'"></i>
                    </div>
                    <div x-show="openFaq === 1" class="mt-3 text-sm text-slate-600 leading-relaxed" style="display: none;">
                        Both Invoices and Customers support a <code class="text-xs bg-slate-200 px-1 py-0.5 rounded font-mono">metadata</code> object in requests. You can pass order IDs, CRM tags, or internal department codes. You can also query records via API using <code class="text-xs bg-slate-200 px-1 py-0.5 rounded font-mono">?metadata[your_key]=value</code>.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5 cursor-pointer" @click="openFaq = openFaq === 2 ? null : 2">
                    <div class="flex items-center justify-between font-bold text-slate-900 text-base">
                        <span>What makes Cursor Pagination better than standard pagination?</span>
                        <i class="fa-solid" :class="openFaq === 2 ? 'fa-chevron-up text-indigo-600' : 'fa-chevron-down text-slate-400'"></i>
                    </div>
                    <div x-show="openFaq === 2" class="mt-3 text-sm text-slate-600 leading-relaxed" style="display: none;">
                        Standard offset pagination scans thousands of rows in the database, becoming slow on large datasets ($O(N)$ complexity) and causing duplicate records during live writes. Cursor pagination operates in $O(1)$ constant time by seeking directly on indexed keys.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5 cursor-pointer" @click="openFaq = openFaq === 3 ? null : 3">
                    <div class="flex items-center justify-between font-bold text-slate-900 text-base">
                        <span>Can I generate invoices without an account?</span>
                        <i class="fa-solid" :class="openFaq === 3 ? 'fa-chevron-up text-indigo-600' : 'fa-chevron-down text-slate-400'"></i>
                    </div>
                    <div x-show="openFaq === 3" class="mt-3 text-sm text-slate-600 leading-relaxed" style="display: none;">
                        Yes! Guests can use our quick Invoice Studio to build and download invoices in guest session mode. To save clients, access the API, and dispatch webhooks, you can sign up for a free account.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Footer -->
    <footer class="bg-slate-950 text-slate-400 py-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-base shadow-sm">
                            ⚡
                        </div>
                        <span class="text-xl font-extrabold text-white">Invozen</span>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Modern Invoicing as a Service & Developer Microservice Platform. Built on PHP 8.4 and Laravel 12.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-3">Product</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('invoice.builder') }}" class="hover:text-white transition-colors">Invoice Builder</a></li>
                        <li><a href="{{ route('api-docs') }}" class="hover:text-white transition-colors">Developer API</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-3">Resources</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('api-docs') }}" class="hover:text-white transition-colors">API Reference</a></li>
                        <li><a href="{{ route('pp') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('t&c') }}" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-3">Community</h4>
                    <div class="flex items-center space-x-3 text-slate-400 text-sm mb-4">
                        <a href="https://github.com" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center hover:text-white hover:bg-slate-800 transition-colors"><i class="fa-brands fa-github"></i></a>
                        <a href="https://twitter.com" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center hover:text-white hover:bg-slate-800 transition-colors"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://discord.com" target="_blank" class="w-8 h-8 rounded-lg bg-slate-900 flex items-center justify-center hover:text-white hover:bg-slate-800 transition-colors"><i class="fa-brands fa-discord"></i></a>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                        All Systems Operational
                    </span>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Invozen Inc. All rights reserved.</p>
                <p class="mt-2 sm:mt-0">Engineered with ❤️ for high-performance invoicing.</p>
            </div>
        </div>
    </footer>
</x-home-layout>
