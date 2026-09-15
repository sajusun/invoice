<x-app-layout>
    <x-slot name="title">Developer API Reference & Docs - Invozen</x-slot>

    <div class="bg-gray-900 text-gray-100 min-h-screen">
        <!-- Hero Header -->
        <div class="border-b border-gray-800 bg-gray-950/60 py-12 px-6">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
                        <i class="fa-solid fa-bolt"></i> Invoicing-as-a-Service API v1.0
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                        Developer API Reference
                    </h1>
                    <p class="text-gray-400 text-sm sm:text-base mt-2 max-w-2xl">
                        Integrate programmatic invoicing, customer sync, PDF generation, and automated billing into your applications, WooCommerce, LMS, or SaaS platforms.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('developer.api-keys') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg transition">
                            <i class="fa-solid fa-key"></i> Manage API Keys
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-semibold rounded-xl shadow-lg transition">
                            <i class="fa-solid fa-right-to-bracket"></i> Get Free API Key
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Sidebar Navigation -->
            <div class="lg:col-span-3 space-y-6">
                <div class="sticky top-6 bg-gray-800/60 border border-gray-700/60 rounded-2xl p-4 backdrop-blur-sm space-y-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400 px-3">Getting Started</span>
                        <div class="mt-2 space-y-1">
                            <a href="#overview" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">Overview & Base URL</a>
                            <a href="#authentication" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">Authentication</a>
                            <a href="#rate-limits" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">Rate Limits & Errors</a>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400 px-3">Invoices API</span>
                        <div class="mt-2 space-y-1">
                            <a href="#create-invoice" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">
                                <span class="text-emerald-400 font-mono text-xs font-bold mr-1">POST</span> Create Invoice
                            </a>
                            <a href="#list-invoices" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">
                                <span class="text-blue-400 font-mono text-xs font-bold mr-1">GET</span> List Invoices
                            </a>
                            <a href="#get-invoice" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">
                                <span class="text-blue-400 font-mono text-xs font-bold mr-1">GET</span> Get Invoice
                            </a>
                            <a href="#pdf-invoice" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">
                                <span class="text-purple-400 font-mono text-xs font-bold mr-1">PDF</span> Download PDF
                            </a>
                            <a href="#mark-paid" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">
                                <span class="text-amber-400 font-mono text-xs font-bold mr-1">POST</span> Mark Paid
                            </a>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-gray-400 px-3">Customers & Webhooks</span>
                        <div class="mt-2 space-y-1">
                            <a href="#customers" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">Customers API</a>
                            <a href="#account" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">Account & Quota</a>
                            <a href="#webhooks" class="block px-3 py-1.5 text-sm text-gray-300 hover:text-white hover:bg-gray-700/50 rounded-lg transition">Webhooks & HMAC</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="lg:col-span-9 space-y-12">
                <!-- Overview -->
                <section id="overview" class="space-y-4">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-server text-blue-400"></i> Overview & Base URL
                    </h2>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        The Invozen API is organized around REST. All request bodies should be JSON-encoded, and responses return predictable, standard JSON data structures with HTTP status codes.
                    </p>
                    <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 font-mono text-sm flex items-center justify-between">
                        <div>
                            <span class="text-gray-500">Base URL:</span>
                            <span class="text-blue-400 ml-2 font-semibold">{{ url('/api/v1') }}</span>
                        </div>
                        <span class="text-xs text-gray-400 bg-gray-800 px-2.5 py-1 rounded">HTTPS Required in Production</span>
                    </div>
                </section>

                <!-- Authentication -->
                <section id="authentication" class="space-y-4">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-emerald-400"></i> Authentication
                    </h2>
                    <p class="text-gray-300 text-sm">
                        Authenticate all API requests by passing your Secret Key in the <code>Authorization</code> header as a Bearer token:
                    </p>
                    <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 font-mono text-xs sm:text-sm text-emerald-400">
                        Authorization: Bearer {{ $apiKey ? 'inv_live_sk_' . ($apiKey->secret_preview ?? '••••••••') : 'inv_live_sk_your_secret_key_here' }}
                    </div>
                    <p class="text-xs text-gray-400">
                        Never share or commit your Secret Key to client-side code, frontend JavaScript, or public GitHub repositories.
                    </p>
                </section>

                <!-- 1. Create Invoice -->
                <section id="create-invoice" class="space-y-4 pt-6 border-t border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-1 text-xs font-bold font-mono rounded bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">POST</span>
                        <h3 class="text-xl font-bold text-white">/api/v1/invoices</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Create a complete invoice. You can specify an existing <code>customer_id</code> or pass a <code>customer</code> object to automatically create or associate the client.
                    </p>

                    <!-- Code Tabs (cURL / PHP / JS) -->
                    <div class="bg-gray-950 rounded-2xl border border-gray-800 overflow-hidden">
                        <div class="bg-gray-900 px-4 py-2.5 border-b border-gray-800 flex items-center justify-between text-xs text-gray-400 font-medium">
                            <span>Request Example (cURL)</span>
                            <span>JSON Body</span>
                        </div>
                        <pre class="p-5 font-mono text-xs leading-relaxed text-gray-300 overflow-x-auto"><code>curl -X POST "{{ url('/api/v1/invoices') }}" \
  -H "Authorization: Bearer inv_live_sk_xxxxxx" \
  -H "Content-Type: application/json" \
  -d '{
    "customer": {
      "name": "Acme Global Inc.",
      "email": "billing@acmeglobal.com",
      "phone": "+1 555-0199",
      "address": "100 Innovation Way, Austin, TX"
    },
    "currency": "USD",
    "invoice_date": "{{ date('Y-m-d') }}",
    "notes": "Thank you for your business. Net 30 terms.",
    "need_tax": true,
    "tax_rate": 10.00,
    "items": [
      {
        "name": "Full-Stack Web App Development",
        "qty": 40,
        "rate": 75.00
      },
      {
        "name": "Cloud Infrastructure & Docker Deployment",
        "qty": 1,
        "rate": 350.00
      }
    ]
  }'</code></pre>
                    </div>

                    <!-- Response Preview -->
                    <div class="bg-gray-950 rounded-2xl border border-gray-800 overflow-hidden">
                        <div class="bg-gray-900 px-4 py-2.5 border-b border-gray-800 text-xs text-emerald-400 font-medium">
                            Response 201 Created
                        </div>
                        <pre class="p-5 font-mono text-xs text-gray-300 overflow-x-auto"><code>{
  "success": true,
  "message": "Invoice created successfully.",
  "data": {
    "id": 142,
    "invoice_number": "INV-1025",
    "invoice_date": "{{ date('Y-m-d') }}",
    "status": "unpaid",
    "currency": "USD",
    "subtotal": 3350.00,
    "tax_amount": 335.00,
    "total_amount": 3685.00,
    "paid_amount": 0.00,
    "due_amount": 3685.00,
    "customer": {
      "id": 12,
      "name": "Acme Global Inc.",
      "email": "billing@acmeglobal.com",
      "phone": "+1 555-0199"
    },
    "public_url": "{{ url('/invoice/INV-1025/preview') }}",
    "pdf_url": "{{ url('/api/v1/invoices/142/pdf') }}"
  }
}</code></pre>
                    </div>
                </section>

                <!-- 2. List Invoices -->
                <section id="list-invoices" class="space-y-4 pt-6 border-t border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-1 text-xs font-bold font-mono rounded bg-blue-500/20 text-blue-400 border border-blue-500/30">GET</span>
                        <h3 class="text-xl font-bold text-white">/api/v1/invoices</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Filter, search, and paginate through your invoices.
                    </p>
                    <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 font-mono text-xs text-gray-300">
                        curl -X GET "{{ url('/api/v1/invoices?status=paid&per_page=10') }}" \<br>
                        &nbsp;&nbsp;-H "Authorization: Bearer inv_live_sk_xxxxxx"
                    </div>
                </section>

                <!-- 3. PDF Download -->
                <section id="pdf-invoice" class="space-y-4 pt-6 border-t border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-1 text-xs font-bold font-mono rounded bg-purple-500/20 text-purple-400 border border-purple-500/30">GET</span>
                        <h3 class="text-xl font-bold text-white">/api/v1/invoices/{id}/pdf</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Download or stream the generated PDF document directly as binary stream (<code>application/pdf</code>).
                    </p>
                    <div class="bg-gray-950 p-4 rounded-xl border border-gray-800 font-mono text-xs text-gray-300">
                        curl -X GET "{{ url('/api/v1/invoices/142/pdf') }}" \<br>
                        &nbsp;&nbsp;-H "Authorization: Bearer inv_live_sk_xxxxxx" \<br>
                        &nbsp;&nbsp;--output invoice_142.pdf
                    </div>
                </section>

                <!-- 4. Mark Paid -->
                <section id="mark-paid" class="space-y-4 pt-6 border-t border-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-1 text-xs font-bold font-mono rounded bg-amber-500/20 text-amber-400 border border-amber-500/30">POST</span>
                        <h3 class="text-xl font-bold text-white">/api/v1/invoices/{id}/mark-paid</h3>
                    </div>
                    <p class="text-gray-300 text-sm">
                        Mark an unpaid or overdue invoice as fully paid. Triggers the <code>invoice.paid</code> webhook automatically.
                    </p>
                </section>

                <!-- 5. Webhooks Guide -->
                <section id="webhooks" class="space-y-4 pt-6 border-t border-gray-800">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-satellite-dish text-purple-400"></i> Webhooks & HMAC Verification
                    </h2>
                    <p class="text-gray-300 text-sm">
                        Invozen signs all webhook events using an HMAC SHA-256 signature passed in the <code>X-Invozen-Signature</code> header.
                    </p>
                    <div class="bg-gray-950 p-5 rounded-2xl border border-gray-800 space-y-3">
                        <span class="text-xs font-bold text-purple-400 uppercase tracking-wider block">PHP Webhook Receiver Example:</span>
                        <pre class="font-mono text-xs text-gray-300 overflow-x-auto"><code>$payload   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_INVOZEN_SIGNATURE'] ?? '';
$timestamp = $_SERVER['HTTP_X_INVOZEN_TIMESTAMP'] ?? '';
$secret    = 'whsec_your_webhook_secret_here';

$expectedSignature = hash_hmac('sha256', "{$timestamp}.{$payload}", $secret);

if (hash_equals($expectedSignature, $signature)) {
    $event = json_decode($payload, true);
    // Handle $event['event'] == 'invoice.paid'
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(401);
}</code></pre>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
