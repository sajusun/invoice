<x-admin-layout>
    <x-slot name="title">Admin SaaS Platform Overview - Invozen</x-slot>

    <div class="bg-gray-50 p-4 sm:p-6 lg:p-8 space-y-8 max-w-7xl mx-auto overflow-y-auto">
        <!-- 1. Header & Live Indicator -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
            <div>
                <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Platform Live
                </div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Admin SaaS Management Hub</h1>
                <p class="text-sm text-gray-500 mt-0.5">Platform growth analytics, user subscriptions, and financial metrics.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard.payments.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-plus"></i> Manual Subscription Override
                </a>
            </div>
        </div>

        <!-- 2. High-Level Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-ui.stat-card
                title="Total Users"
                value="{{ number_format($totalUsers) }}"
                icon="fa-solid fa-users"
                color="blue"
                trend="+{{ $usersThisWeek }} this week"
                trendType="positive"
                subtitle="{{ $verifiedUsers }} Verified ({{ $totalUsers > 0 ? round(($verifiedUsers / $totalUsers) * 100) : 0 }}%)"
            />

            <x-ui.stat-card
                title="Paid Subscribers"
                value="{{ number_format($paidUsersCount) }}"
                icon="fa-solid fa-star"
                color="purple"
                trend="{{ $totalUsers > 0 ? round(($paidUsersCount / $totalUsers) * 100) : 0 }}% Conversion"
                trendType="positive"
                subtitle="Premium & Business users"
            />

            <x-ui.stat-card
                title="Platform Revenue"
                value="${{ number_format($totalPlatformRevenue, 2) }}"
                icon="fa-solid fa-money-bill-wave"
                color="emerald"
                trend="All-Time Payments"
                trendType="neutral"
                subtitle="From Stripe, PayPal, etc."
            />

            <x-ui.stat-card
                title="Invoices Created"
                value="{{ number_format($totalPlatformInvoices) }}"
                icon="fa-solid fa-file-invoice"
                color="indigo"
                trend="Platform-Wide Activity"
                trendType="neutral"
                subtitle="Total documents created"
            />
        </div>

        <!-- 3. Platform Analytics (Registration Trend + Plan Distribution) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- 7-Day User Growth Chart -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-plus text-blue-600"></i>
                            User Registration Growth (Last 7 Days)
                        </h2>
                        <p class="text-xs text-gray-500">Daily signups curve</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-gray-100 rounded-lg text-gray-700">
                        {{ array_sum($regTrendData) }} New Signups
                    </span>
                </div>
                <div class="relative h-64 sm:h-72 w-full">
                    <canvas id="adminRegChart"></canvas>
                </div>
            </div>

            <!-- Subscription Plan Distribution -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm space-y-4">
                <div class="border-b border-gray-100 pb-3">
                    <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-purple-600"></i>
                        Plan Distribution
                    </h2>
                    <p class="text-xs text-gray-500">Active user tiers</p>
                </div>

                <div class="relative h-48 w-full">
                    <canvas id="adminPlanChart"></canvas>
                </div>

                <div class="space-y-2 pt-2 border-t border-gray-100 text-xs">
                    @foreach($plans as $p)
                        <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50">
                            <span class="font-medium text-gray-800">{{ $p->name }} (${{ $p->price }}/mo)</span>
                            <span class="font-bold text-gray-900">{{ $p->users_count }} users</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 4. Users Table & Quick Filters -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-users text-blue-600"></i>
                            Users Directory
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Manage, inspect, and override user accounts</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-full">
                        {{ $usersList->total() }} Total Results
                    </span>
                </div>

                <!-- Filters Form -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2">
                    <div class="sm:col-span-5">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by ID, name, email..."
                               class="w-full text-xs border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="sm:col-span-3">
                        <select name="status" onchange="this.form.submit()"
                                class="w-full text-xs border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">All Verification Status</option>
                            <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified Users</option>
                            <option value="unverified" {{ request('status') === 'unverified' ? 'selected' : '' }}>Unverified Users</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid Subscribers Only</option>
                            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New (Today)</option>
                        </select>
                    </div>
                    <div class="sm:col-span-3">
                        <select name="plan_id" onchange="this.form.submit()"
                                class="w-full text-xs border border-gray-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">All Subscription Plans</option>
                            @foreach($plans as $p)
                                <option value="{{ $p->id }}" {{ request('plan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} Plan (${{ $p->price }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-1 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="w-full text-center px-3 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase font-semibold text-gray-500">
                        <tr>
                            <th class="py-3.5 px-5">User</th>
                            <th class="py-3.5 px-5">Plan</th>
                            <th class="py-3.5 px-5">Invoices</th>
                            <th class="py-3.5 px-5">Verification</th>
                            <th class="py-3.5 px-5">Registered</th>
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($usersList as $user)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-4 px-5">
                                    <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $user->email }} (ID: #{{ $user->id }})</div>
                                </td>
                                <td class="py-4 px-5">
                                    <x-ui.badge :status="$user->plan?->type ?? 'free'" size="sm" />
                                </td>
                                <td class="py-4 px-5 text-xs font-semibold text-gray-700">
                                    {{ $user->invoices_count }} {{ Str::plural('invoice', $user->invoices_count) }}
                                </td>
                                <td class="py-4 px-5">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1 text-xs text-emerald-700 font-medium">
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs text-amber-700 font-medium">
                                            <i class="fa-solid fa-clock text-amber-500"></i> Unverified
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-xs text-gray-500">
                                    {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.dashboard.user.page', $user->id) }}"
                                           class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                            View Details
                                        </a>
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Permanently delete user {{ $user->name }}? All associated invoices will be erased.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-sm text-gray-500">
                                    No users matching criteria found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($usersList->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    {{ $usersList->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Admin Charts Initialization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Registration Growth Chart
            const regCtx = document.getElementById('adminRegChart');
            if (regCtx) {
                new Chart(regCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($regTrendLabels) !!},
                        datasets: [{
                            label: 'New Users',
                            data: {!! json_encode($regTrendData) !!},
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointBackgroundColor: '#2563eb',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                            y: { grid: { color: '#f3f4f6' }, beginAtZero: true, ticks: { precision: 0 } }
                        }
                    }
                });
            }

            // 2. Plan Distribution Donut Chart
            const planCtx = document.getElementById('adminPlanChart');
            if (planCtx) {
                new Chart(planCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($planDistributionLabels) !!},
                        datasets: [{
                            data: {!! json_encode($planDistributionData) !!},
                            backgroundColor: ['#9ca3af', '#2563eb', '#9333ea'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, font: { size: 11 } }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-admin-layout>
