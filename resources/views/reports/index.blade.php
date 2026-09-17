<x-dashboard-layout>
    <x-slot name="title">Financial Reports & Analytics - {{ $user->settings?->company_name ?? 'Invozen' }}</x-slot>

    <!-- Load Chart.js for visualizations -->
    <x-slot name="meta">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    </x-slot>

    <div class="content p-4 sm:p-6 lg:p-8 space-y-8 max-w-7xl mx-auto overflow-y-auto"
         x-data="{ 
            rangePreset: '{{ $filters['range'] }}',
            showCustomDates: {{ $filters['range'] === 'custom' ? 'true' : 'false' }}
         }">

        <!-- 1. Header & Quick Export Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                    <span class="text-slate-800">Financial Reports</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                    <span>Financial Analytics & Reports</span>
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 max-w-2xl leading-relaxed">
                    Track revenue performance, tax collections, cash inflow efficiency, and export accounting statements.
                </p>
            </div>

            <!-- Export Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('reports.export.csv', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-bold rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition-all">
                    <i class="fa-solid fa-file-csv text-emerald-600 text-base"></i>
                    <span>Export CSV</span>
                </a>

                <a href="{{ route('reports.export.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition-all">
                    <i class="fa-solid fa-file-pdf text-xs"></i>
                    <span>Download PDF Statement</span>
                </a>
            </div>
        </div>

        <!-- 2. Dynamic Filter Bar -->
        <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200/80 shadow-sm space-y-4">
            <form method="GET" action="{{ route('reports.index') }}" class="space-y-4">
                <!-- Date Presets Row -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">Period:</span>
                        
                        @php
                            $presets = [
                                'this_month'   => 'This Month',
                                'last_month'   => 'Last Month',
                                'this_quarter' => 'This Quarter',
                                'this_year'    => 'This Year',
                                'all_time'     => 'All Time',
                            ];
                        @endphp

                        @foreach($presets as $key => $label)
                            <button type="submit" name="range" value="{{ $key }}"
                                    @click="rangePreset = '{{ $key }}'; showCustomDates = false"
                                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all
                                    {{ $filters['range'] === $key ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100/80 hover:bg-slate-200 text-slate-600' }}">
                                {{ $label }}
                            </button>
                        @endforeach

                        <button type="button" @click="showCustomDates = !showCustomDates; rangePreset = 'custom'"
                                :class="showCustomDates ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100/80 hover:bg-slate-200 text-slate-600'"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5">
                            <i class="fa-regular fa-calendar-days text-[11px]"></i>
                            <span>Custom Range</span>
                        </button>
                    </div>

                    <!-- Active Period Indicator -->
                    <div class="text-xs text-slate-500 font-semibold flex items-center gap-1.5 bg-slate-50 px-3 py-1 rounded-xl border border-slate-200/60">
                        <i class="fa-regular fa-clock text-blue-600"></i>
                        <span>Active: <strong class="text-slate-800">{{ $summary['date_range']['label'] }}</strong></span>
                    </div>
                </div>

                <!-- Secondary Filters: Client, Status & Custom Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-end">
                    <!-- Client Dropdown -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Filter by Client</label>
                        <select name="customer_id" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 py-2.5 px-3 font-medium text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Clients ({{ $allCustomers->count() }})</option>
                            @foreach($allCustomers as $cust)
                                <option value="{{ $cust->id }}" {{ $filters['customer_id'] == $cust->id ? 'selected' : '' }}>
                                    {{ $cust->name }} {{ $cust->company_name ? "({$cust->company_name})" : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Dropdown -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Invoice Status</label>
                        <select name="status" class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 py-2.5 px-3 font-medium text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="paid" {{ $filters['status'] === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ $filters['status'] === 'unpaid' ? 'selected' : '' }}>Unpaid / Pending</option>
                            <option value="partially_paid" {{ $filters['status'] === 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                            <option value="overdue" {{ $filters['status'] === 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>

                    <!-- Custom Date From -->
                    <div x-show="showCustomDates" style="display: none;">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">From Date</label>
                        <input type="date" name="from_date" value="{{ $filters['from_date'] ?? '' }}"
                               class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 py-2 px-3 text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Custom Date To & Action -->
                    <div x-show="showCustomDates" style="display: none;">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">To Date</label>
                        <input type="date" name="to_date" value="{{ $filters['to_date'] ?? '' }}"
                               class="w-full text-xs rounded-xl border-slate-200 bg-slate-50/50 py-2 px-3 text-slate-800 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <!-- Apply & Reset Buttons -->
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="range" :value="rangePreset">
                        <button type="submit"
                                class="flex-1 py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-xs transition">
                            Apply Filter
                        </button>
                        @if(request()->hasAny(['customer_id', 'status', 'from_date', 'to_date']) || ($filters['range'] !== 'this_month'))
                            <a href="{{ route('reports.index') }}"
                               class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition" title="Reset Filters">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- 3. Key Financial Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Invoiced -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-xs">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                        {{ $summary['total_invoices_count'] }} Invoices
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Invoiced</h3>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 font-mono mt-1 mb-1">
                    {{ $currency }} {{ number_format($summary['total_billed'], 2) }}
                </div>
                <span class="text-xs text-slate-500 font-medium">
                    Avg. invoice value: <strong>{{ $currency }} {{ number_format($summary['avg_invoice_value'], 2) }}</strong>
                </span>
            </div>

            <!-- Collected Cash -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-xs">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                        {{ $summary['collection_rate'] }}% Rate
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Cash Collected</h3>
                <div class="text-2xl sm:text-3xl font-black text-emerald-600 font-mono mt-1 mb-1">
                    {{ $currency }} {{ number_format($summary['total_paid'], 2) }}
                </div>
                <span class="text-xs text-slate-500 font-medium">
                    <strong>{{ $summary['paid_count'] }}</strong> fully settled invoices
                </span>
            </div>

            <!-- Outstanding Receivables -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shadow-xs">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 border border-amber-100">
                        {{ $summary['unpaid_count'] + $summary['partially_paid_count'] + $summary['overdue_count'] }} Pending
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Outstanding Receivables</h3>
                <div class="text-2xl sm:text-3xl font-black text-amber-600 font-mono mt-1 mb-1">
                    {{ $currency }} {{ number_format($summary['total_due'], 2) }}
                </div>
                <span class="text-xs text-slate-500 font-medium">
                    Unpaid balance across clients
                </span>
            </div>

            <!-- Total Tax Collected -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg shadow-xs">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 border border-purple-100">
                        Accounting
                    </span>
                </div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sales Tax & VAT</h3>
                <div class="text-2xl sm:text-3xl font-black text-purple-600 font-mono mt-1 mb-1">
                    {{ $currency }} {{ number_format($summary['total_tax'], 2) }}
                </div>
                <span class="text-xs text-slate-500 font-medium">
                    Discounts given: <strong>{{ $currency }} {{ number_format($summary['total_discount'], 2) }}</strong>
                </span>
            </div>
        </div>

        <!-- 4. Visualizations: Monthly Revenue Trend & Status Doughnut -->
        <div class="grid lg:grid-cols-12 gap-6 items-stretch">
            <!-- Revenue vs Collection 6-Month Chart -->
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line-up text-blue-600"></i>
                            <span>Revenue vs. Cash Collection Trend</span>
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">Rolling 6-month financial performance</p>
                    </div>

                    <div class="flex items-center gap-3 text-xs font-semibold">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Invoiced
                        </span>
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Collected
                        </span>
                    </div>
                </div>

                <div class="relative h-72 w-full">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>

            <!-- Status Distribution Doughnut Chart -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-chart-pie text-indigo-600"></i>
                        <span>Invoice Status Distribution</span>
                    </h2>
                    <p class="text-xs text-slate-400 mb-4">Breakdown for {{ $summary['date_range']['label'] }}</p>

                    <div class="relative h-48 w-full flex items-center justify-center">
                        <canvas id="statusDoughnutChart"></canvas>
                    </div>
                </div>

                <!-- Status Legend Matrix -->
                <div class="grid grid-cols-2 gap-2 text-xs pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/60 border border-emerald-100">
                        <span class="font-medium text-emerald-800">Paid</span>
                        <strong class="font-mono text-emerald-900">{{ $summary['paid_count'] }}</strong>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-amber-50/60 border border-amber-100">
                        <span class="font-medium text-amber-800">Pending</span>
                        <strong class="font-mono text-amber-900">{{ $summary['unpaid_count'] }}</strong>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-rose-50/60 border border-rose-100">
                        <span class="font-medium text-rose-800">Overdue</span>
                        <strong class="font-mono text-rose-900">{{ $summary['overdue_count'] }}</strong>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-100 border border-slate-200">
                        <span class="font-medium text-slate-600">Cancelled</span>
                        <strong class="font-mono text-slate-800">{{ $summary['canceled_count'] }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Client Revenue Leaderboard & Aging Breakdown Grid -->
        <div class="grid lg:grid-cols-12 gap-6 items-stretch">
            <!-- Top Clients Leaderboard -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-trophy text-amber-500"></i>
                                <span>Client Revenue Ranking</span>
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Top-spending client accounts in this period</p>
                        </div>
                        <span class="text-xs font-semibold text-slate-400">Top {{ $topClients->count() }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">
                                    <th class="py-2.5 px-3">Client</th>
                                    <th class="py-2.5 px-3 text-right">Invoiced</th>
                                    <th class="py-2.5 px-3 text-right">Paid</th>
                                    <th class="py-2.5 px-3 text-right">Outstanding</th>
                                    <th class="py-2.5 px-3 text-right">Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($topClients as $client)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="py-3 px-3 font-semibold text-slate-800">
                                            <a href="{{ route('customers.details', $client->id) }}" class="hover:text-blue-600 transition flex flex-col">
                                                <span>{{ $client->name }}</span>
                                                @if($client->company_name)
                                                    <span class="text-[10px] text-slate-400 font-normal">{{ $client->company_name }}</span>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="py-3 px-3 text-right font-mono font-bold text-slate-900">
                                            {{ $currency }} {{ number_format($client->total_billed, 2) }}
                                        </td>
                                        <td class="py-3 px-3 text-right font-mono text-emerald-600 font-semibold">
                                            {{ $currency }} {{ number_format($client->total_paid, 2) }}
                                        </td>
                                        <td class="py-3 px-3 text-right font-mono font-bold {{ $client->total_due > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                                            {{ $currency }} {{ number_format($client->total_due, 2) }}
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold
                                                {{ $client->collection_rate >= 90 ? 'bg-emerald-50 text-emerald-700' : ($client->collection_rate >= 50 ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700') }}">
                                                {{ $client->collection_rate }}%
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-400">
                                            No revenue data for clients in this date range.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Manage all client contact profiles</span>
                    <a href="{{ route('customers') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">
                        View Clients &rarr;
                    </a>
                </div>
            </div>

            <!-- Aging & Receivables Analysis -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-rose-500"></i>
                                <span>Receivables Aging Analysis</span>
                            </h2>
                            <p class="text-xs text-slate-400 mt-0.5">Debt risk timeline across all unpaid invoices</p>
                        </div>
                        <span class="text-xs font-mono font-bold text-slate-900">
                            {{ $currency }} {{ number_format($aging['total'], 2) }}
                        </span>
                    </div>

                    <div class="space-y-4 my-2">
                        <!-- Current (Not Overdue) -->
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-semibold text-slate-700">Current (Not Due Yet)</span>
                                <span class="font-mono font-bold text-slate-900">{{ $currency }} {{ number_format($aging['current'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $aging['current_percent'] }}%"></div>
                            </div>
                        </div>

                        <!-- 1 - 30 Days Overdue -->
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-semibold text-amber-700">1 – 30 Days Overdue</span>
                                <span class="font-mono font-bold text-amber-900">{{ $currency }} {{ number_format($aging['days_1_30'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full" style="width: {{ $aging['days_1_30_percent'] }}%"></div>
                            </div>
                        </div>

                        <!-- 31 - 60 Days Overdue -->
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-semibold text-orange-700">31 – 60 Days Overdue</span>
                                <span class="font-mono font-bold text-orange-900">{{ $currency }} {{ number_format($aging['days_31_60'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-orange-500 h-full rounded-full" style="width: {{ $aging['days_31_60_percent'] }}%"></div>
                            </div>
                        </div>

                        <!-- 60+ Days Overdue -->
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-semibold text-rose-700">60+ Days Overdue (High Risk)</span>
                                <span class="font-mono font-bold text-rose-900">{{ $currency }} {{ number_format($aging['days_60_plus'], 2) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-rose-600 h-full rounded-full" style="width: {{ $aging['days_60_percent'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 text-xs text-slate-500 flex items-center justify-between">
                    <span>Send automated reminder emails</span>
                    <a href="{{ route('invoices') }}?status=overdue" class="font-bold text-rose-600 hover:text-rose-800 transition">
                        View Overdue &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- 6. Itemized Invoices Statement Table -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-blue-600"></i>
                        <span>Filtered Invoices Statement</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Showing all {{ $invoices->count() }} invoice records matching current query parameters</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('reports.export.csv', request()->query()) }}" class="text-xs font-bold text-blue-600 hover:underline">
                        <i class="fa-solid fa-download text-[11px] mr-1"></i> CSV
                    </a>
                    <span class="text-slate-300">•</span>
                    <a href="{{ route('reports.export.pdf', request()->query()) }}" class="text-xs font-bold text-blue-600 hover:underline">
                        <i class="fa-solid fa-file-pdf text-[11px] mr-1"></i> PDF Statement
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 text-[11px] uppercase tracking-wider font-bold border-b border-slate-100">
                            <th class="py-3 px-4">Invoice #</th>
                            <th class="py-3 px-4">Client</th>
                            <th class="py-3 px-4">Issue Date</th>
                            <th class="py-3 px-4">Due Date</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Tax</th>
                            <th class="py-3 px-4 text-right">Total Amount</th>
                            <th class="py-3 px-4 text-right">Paid</th>
                            <th class="py-3 px-4 text-right">Due Balance</th>
                            <th class="py-3 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-600">
                        @forelse($invoices as $inv)
                            @php
                                $due = max(0, (float) $inv->total_amount - (float) $inv->paid_amount);
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4 font-mono font-bold text-slate-900">
                                    <a href="{{ route('previewInvoice', $inv->invoice_number) }}" class="hover:text-blue-600 transition">
                                        {{ $inv->invoice_number }}
                                    </a>
                                </td>

                                <td class="py-3.5 px-4 font-medium text-slate-800">
                                    {{ $inv->customer?->name ?? 'N/A' }}
                                </td>

                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ \Carbon\Carbon::parse($inv->invoice_date)->format('M d, Y') }}
                                </td>

                                <td class="py-3.5 px-4 text-slate-500">
                                    {{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('M d, Y') : '-' }}
                                </td>

                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $inv->status === 'paid' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($inv->status === 'overdue' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                        {{ ucfirst($inv->status) }}
                                    </span>
                                </td>

                                <td class="py-3.5 px-4 text-right font-mono text-slate-600">
                                    {{ number_format($inv->tax_amount, 2) }}
                                </td>

                                <td class="py-3.5 px-4 text-right font-mono font-bold text-slate-900">
                                    {{ $currency }} {{ number_format($inv->total_amount, 2) }}
                                </td>

                                <td class="py-3.5 px-4 text-right font-mono text-emerald-600 font-semibold">
                                    {{ number_format($inv->paid_amount, 2) }}
                                </td>

                                <td class="py-3.5 px-4 text-right font-mono font-bold {{ $due > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                                    {{ number_format($due, 2) }}
                                </td>

                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('previewInvoice', $inv->invoice_number) }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-[11px] transition">
                                        <i class="fa-solid fa-eye text-[10px]"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-10 text-center text-slate-400">
                                    No invoices found matching the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Revenue Timeline Chart
            const ctxTimeline = document.getElementById('revenueTrendChart');
            if (ctxTimeline) {
                new Chart(ctxTimeline, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($timeline['labels']) !!},
                        datasets: [
                            {
                                label: 'Total Invoiced',
                                data: {!! json_encode($timeline['billed']) !!},
                                backgroundColor: 'rgba(37, 99, 235, 0.85)',
                                borderColor: 'rgb(37, 99, 235)',
                                borderRadius: 8,
                                borderSkipped: false,
                                barPercentage: 0.6,
                            },
                            {
                                label: 'Collected Cash',
                                data: {!! json_encode($timeline['paid']) !!},
                                backgroundColor: 'rgba(16, 185, 129, 0.85)',
                                borderColor: 'rgb(16, 185, 129)',
                                borderRadius: 8,
                                borderSkipped: false,
                                barPercentage: 0.6,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                padding: 12,
                                cornerRadius: 10,
                                callbacks: {
                                    label: function (context) {
                                        return context.dataset.label + ': {{ $currency }} ' + Number(context.raw).toLocaleString(undefined, {minimumFractionDigits: 2});
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: '#64748b'
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.8)'
                                },
                                ticks: {
                                    font: {
                                        size: 11
                                    },
                                    color: '#64748b',
                                    callback: function (val) {
                                        return '{{ $currency }} ' + val.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // 2. Status Doughnut Chart
            const ctxDoughnut = document.getElementById('statusDoughnutChart');
            if (ctxDoughnut) {
                const paidCount = {{ $summary['paid_count'] }};
                const unpaidCount = {{ $summary['unpaid_count'] + $summary['partially_paid_count'] }};
                const overdueCount = {{ $summary['overdue_count'] }};
                const canceledCount = {{ $summary['canceled_count'] }};
                const totalCount = paidCount + unpaidCount + overdueCount + canceledCount;

                new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: ['Paid', 'Pending', 'Overdue', 'Cancelled'],
                        datasets: [{
                            data: totalCount > 0 ? [paidCount, unpaidCount, overdueCount, canceledCount] : [1],
                            backgroundColor: totalCount > 0 ? [
                                'rgba(16, 185, 129, 0.9)',
                                'rgba(245, 158, 11, 0.9)',
                                'rgba(239, 68, 68, 0.9)',
                                'rgba(148, 163, 184, 0.9)'
                            ] : ['rgba(226, 232, 240, 0.9)'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '72%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                padding: 10,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-dashboard-layout>
