<x-dashboard-layout>
    <x-slot name="title">Dashboard - {{ $user->settings?->company_name ?? 'Invozen' }}</x-slot>

    <div class="content p-4 sm:p-6 lg:p-8 space-y-8 max-w-7xl mx-auto overflow-y-auto">
        <!-- 1. Header & Quick Actions -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-blue-500/10">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/15 backdrop-blur-md text-blue-100 border border-white/20">
                    <i class="fa-regular fa-calendar"></i> {{ now()->format('l, F d, Y') }}
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Welcome back, {{ $user->name }}! 👋
                </h1>
                <p class="text-sm text-blue-100/80 max-w-xl">
                    Here is what's happening with <strong class="text-white">{{ $user->settings?->company_name ?? 'your business' }}</strong> today.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('invoice.builder') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-blue-700 hover:bg-blue-50 text-sm font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fa-solid fa-plus text-blue-600"></i>
                    Create Invoice
                </a>
                <a href="{{ route('customers.add') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white text-sm font-semibold rounded-xl border border-white/20 transition-all duration-200">
                    <i class="fa-solid fa-user-plus"></i>
                    Add Client
                </a>
            </div>
        </div>

        <!-- 2. Financial Metrics Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-ui.stat-card
                title="Total Billed"
                value="{{ $currency }} {{ number_format($totalBilled, 2) }}"
                icon="fa-solid fa-receipt"
                color="blue"
                trend="{{ $totalInvoicesCount }} Total Invoices"
                trendType="neutral"
                subtitle="All active invoices"
            />

            <x-ui.stat-card
                title="Collected Cash"
                value="{{ $currency }} {{ number_format($totalPaid, 2) }}"
                icon="fa-solid fa-circle-check"
                color="emerald"
                trend="{{ $paidCount }} Paid Invoices"
                trendType="positive"
                subtitle="{{ $totalBilled > 0 ? round(($totalPaid / $totalBilled) * 100) : 0 }}% Collection Rate"
            />

            <x-ui.stat-card
                title="Outstanding Due"
                value="{{ $currency }} {{ number_format($totalDue, 2) }}"
                icon="fa-solid fa-clock"
                color="amber"
                trend="{{ $unpaidCount }} Pending"
                trendType="negative"
                subtitle="Awaiting client payment"
            />

            <x-ui.stat-card
                title="Overdue Balance"
                value="{{ $currency }} {{ number_format($overdueAmount, 2) }}"
                icon="fa-solid fa-triangle-exclamation"
                color="rose"
                trend="{{ $overdueCount }} Overdue"
                trendType="negative"
                subtitle="Requires follow-up"
            />
        </div>

        <!-- 3. Revenue Trend Chart & Plan Quota -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Chart -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-gray-100 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-chart-column text-blue-600"></i>
                            Billing & Cashflow Trend (6 Months)
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Comparison between total invoiced amounts and cash collected</p>
                    </div>
                    <div class="flex items-center gap-3 text-xs font-semibold">
                        <span class="flex items-center gap-1.5 text-blue-600">
                            <span class="w-3 h-3 rounded-sm bg-blue-600"></span> Invoiced
                        </span>
                        <span class="flex items-center gap-1.5 text-emerald-600">
                            <span class="w-3 h-3 rounded-sm bg-emerald-500"></span> Collected
                        </span>
                    </div>
                </div>

                <div class="relative h-72 sm:h-80 w-full">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>

            <!-- Right: Status Breakdown & Plan Usage -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Status Breakdown -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-indigo-600"></i>
                        Invoices by Status
                    </h3>

                    <div class="space-y-3 pt-1">
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-emerald-50/60 border border-emerald-100 text-xs">
                            <div class="flex items-center gap-2 font-semibold text-emerald-900">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Paid Invoices
                            </div>
                            <span class="font-bold text-emerald-800">{{ $paidCount }}</span>
                        </div>

                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50/60 border border-amber-100 text-xs">
                            <div class="flex items-center gap-2 font-semibold text-amber-900">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                Unpaid / Pending
                            </div>
                            <span class="font-bold text-amber-800">{{ $unpaidCount }}</span>
                        </div>

                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-rose-50/60 border border-rose-100 text-xs">
                            <div class="flex items-center gap-2 font-semibold text-rose-900">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Overdue
                            </div>
                            <span class="font-bold text-rose-800">{{ $overdueCount }}</span>
                        </div>

                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-gray-50 border border-gray-200 text-xs">
                            <div class="flex items-center gap-2 font-semibold text-gray-700">
                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                Canceled
                            </div>
                            <span class="font-bold text-gray-800">{{ $canceledCount }}</span>
                        </div>
                    </div>
                </div>

                <!-- Plan Usage Quota -->
                <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-cubes text-purple-600"></i>
                            Subscription Quota
                        </h3>
                        <x-ui.badge :status="$plan?->type ?? 'free'" size="sm" />
                    </div>

                    <div class="space-y-3.5 pt-1">
                        <x-ui.quota-bar
                            label="Invoices Generated"
                            :used="$totalInvoicesCount"
                            :limit="$maxInvoices"
                            unit="invoices"
                        />

                        <x-ui.quota-bar
                            label="Clients Stored"
                            :used="$totalClientsCount"
                            :limit="$maxCustomers"
                            unit="clients"
                        />
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <a href="{{ route('subscription.plan') }}"
                           class="w-full text-center block px-3 py-2 text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-xl transition">
                            Manage Subscription & Upgrades →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Recent Invoices Table with Instant Actions -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-blue-600"></i>
                        Recent Invoices
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Your latest customer billing documents</p>
                </div>
                <a href="{{ route('invoices') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700">
                    View All Invoices ({{ $totalInvoicesCount }})
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            @if($recentInvoices->isEmpty())
                <div class="p-12 text-center space-y-3">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900">No Invoices Found</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto">Create your first invoice in seconds with our smart invoice builder.</p>
                    <a href="{{ route('invoice.builder') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-xl hover:bg-blue-700 transition">
                        <i class="fa-solid fa-plus"></i> Create Invoice
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th class="py-3.5 px-5">Invoice #</th>
                                <th class="py-3.5 px-5">Client / Customer</th>
                                <th class="py-3.5 px-5">Date</th>
                                <th class="py-3.5 px-5">Amount</th>
                                <th class="py-3.5 px-5">Status</th>
                                <th class="py-3.5 px-5 text-right">Quick Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentInvoices as $inv)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="py-4 px-5">
                                        <a href="{{ route('previewInvoice', $inv->invoice_number) }}"
                                           class="font-mono font-bold text-blue-600 hover:underline">
                                            {{ $inv->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="font-medium text-gray-900">{{ $inv->customer?->name ?? 'Direct Client' }}</div>
                                        <div class="text-xs text-gray-400">{{ $inv->customer?->email ?? $inv->customer?->phone ?? '—' }}</div>
                                    </td>
                                    <td class="py-4 px-5 text-xs text-gray-600">
                                        {{ \Carbon\Carbon::parse($inv->invoice_date)->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 px-5">
                                        <span class="font-bold text-gray-900">{{ $inv->currency ?? $currency }} {{ number_format($inv->total_amount, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-5">
                                        <x-ui.badge :status="$inv->status" size="sm" />
                                    </td>
                                    <td class="py-4 px-5 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('previewInvoice', $inv->invoice_number) }}"
                                               title="Preview"
                                               class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <button onclick="copyPayLink('{{ route('previewInvoice', $inv->invoice_number) }}')"
                                                    title="Copy Shareable Link"
                                                    class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                                <i class="fa-regular fa-copy"></i>
                                            </button>
                                            @if($inv->status !== 'paid')
                                                <a href="{{ route('changeStatus', ['id' => $inv->invoice_number, 'paymentStatus' => 'Paid']) }}"
                                                   title="Mark as Paid"
                                                   class="p-2 text-gray-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                                    <i class="fa-solid fa-check-double"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- 5. Top Clients & Developer API Card -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Top Clients -->
            <div class="lg:col-span-6 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-crown text-amber-500"></i>
                        Top Clients by Volume
                    </h3>
                    <a href="{{ route('customers') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                        All Clients ({{ $totalClientsCount }}) →
                    </a>
                </div>

                @if($topClients->isEmpty())
                    <p class="text-sm text-gray-500 text-center py-6">No clients added yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach($topClients as $client)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                                <div class="space-y-0.5">
                                    <div class="font-semibold text-sm text-gray-900">{{ $client->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $client->invoices_count }} {{ Str::plural('invoice', $client->invoices_count) }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm text-gray-900">{{ $currency }} {{ number_format($client->total_billed ?? 0, 2) }}</div>
                                    <div class="text-xs text-emerald-600 font-medium">Paid: {{ $currency }} {{ number_format($client->total_paid ?? 0, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Developer API Quick Integration Card -->
            <div class="lg:col-span-6 bg-gradient-to-br from-gray-900 via-gray-900 to-gray-950 text-white rounded-2xl border border-gray-800 p-6 shadow-xl space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-mono font-bold text-sm">
                            <i class="fa-solid fa-terminal"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-white">Invoicing-as-a-Service API</h3>
                            <p class="text-xs text-gray-400">Generate invoices directly from your backend or apps</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                        v1.0 Live
                    </span>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span>Quick cURL Example:</span>
                        <a href="{{ route('api-docs') }}" target="_blank" class="text-blue-400 hover:underline">
                            Full API Docs →
                        </a>
                    </div>
                    <div class="bg-black/60 rounded-xl p-3.5 border border-gray-800 font-mono text-xs text-gray-300 relative group">
                        <pre class="overflow-x-auto"><code>curl -X POST "{{ url('/api/v1/invoices') }}" \
  -H "Authorization: Bearer {{ $activeApiKey ? 'inv_live_sk_' . ($activeApiKey->secret_preview ?? '••••') : 'inv_live_sk_YOUR_KEY' }}" \
  -H "Content-Type: application/json" \
  -d '{"customer":{"name":"Acme","phone":"+155501"},"items":[{"name":"Dev","qty":1,"rate":500}]}'</code></pre>
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <a href="{{ route('developer.api-keys') }}"
                       class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 rounded-xl transition">
                        <i class="fa-solid fa-key"></i>
                        {{ $activeApiKey ? 'Manage API Keys & Webhooks' : 'Generate Secret Key' }}
                    </a>
                    <span class="text-xs text-gray-500">Fast 100ms JSON responses</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueTrendChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartMonths) !!},
                        datasets: [
                            {
                                label: 'Invoiced Amount ({{ $currency }})',
                                data: {!! json_encode($chartInvoiced) !!},
                                backgroundColor: 'rgba(37, 99, 235, 0.85)',
                                borderRadius: 8,
                                barPercentage: 0.6,
                            },
                            {
                                label: 'Collected Cash ({{ $currency }})',
                                data: {!! json_encode($chartPaid) !!},
                                backgroundColor: 'rgba(16, 185, 129, 0.85)',
                                borderRadius: 8,
                                barPercentage: 0.6,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                padding: 12,
                                cornerRadius: 10,
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11, weight: '500' }, color: '#6b7280' }
                            },
                            y: {
                                grid: { color: '#f3f4f6' },
                                ticks: { font: { size: 11 }, color: '#6b7280' },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });

        function copyPayLink(url) {
            navigator.clipboard.writeText(url);
            alert('Shareable invoice link copied to clipboard:\n' + url);
        }
    </script>
</x-dashboard-layout>
