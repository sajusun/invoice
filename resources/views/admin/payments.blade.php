<x-admin-layout>
    <x-slot name="title">Platform Revenue & Transactions</x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto space-y-8">
        <!-- 1. Header & Summary Stats -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Platform Payments & Subscriptions</h1>
                <p class="text-xs text-slate-500 mt-1">Audit platform billing records, subscriber checkouts, and custom manual payments.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard.payments.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-rose-600/20 hover:shadow-md transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Assign Custom / Manual Payment</span>
                </a>
            </div>
        </div>

        <!-- 2. Flash Messages -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- 3. Stat Cards -->
        @php
            $totalRev = $payments->where('payment_status', 'success')->sum('amount');
            $successCount = $payments->where('payment_status', 'success')->count();
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Page Revenue</p>
                    <p class="text-2xl font-black text-slate-900 mt-1">${{ number_format($totalRev, 2) }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Transactions</p>
                    <p class="text-2xl font-black text-slate-900 mt-1">{{ $payments->total() }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Successful Billing</p>
                    <p class="text-2xl font-black text-emerald-600 mt-1">{{ $successCount }} Logs</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <!-- 4. Payments Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-rose-600"></i>
                        <span>Recent Billing Activity</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Chronological record of automated and administrator-assigned transactions.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-3.5 px-6">Transaction Date</th>
                            <th class="py-3.5 px-6">User / Customer</th>
                            <th class="py-3.5 px-6">Subscribed Plan</th>
                            <th class="py-3.5 px-6">Amount</th>
                            <th class="py-3.5 px-6">Gateway / Method</th>
                            <th class="py-3.5 px-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-6 font-medium text-slate-500">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                        <span class="text-[10px] text-slate-400">({{ $payment->created_at->format('H:i') }})</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-6">
                                    @if($payment->user)
                                        <a href="{{ route('admin.dashboard.userPage', $payment->user_id) }}" class="flex items-center gap-3 group">
                                            <div class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                                {{ strtoupper(substr($payment->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $payment->user->name }}</p>
                                                <p class="text-[10px] text-slate-400">{{ $payment->user->email }}</p>
                                            </div>
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">User #{{ $payment->user_id }} (Deleted)</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        <i class="fa-solid fa-gem text-[10px]"></i>
                                        <span>{{ $payment->plan?->name ?? 'Custom Plan' }}</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 font-extrabold text-slate-900 text-sm">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="py-3.5 px-6">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                        <i class="fa-solid fa-credit-card text-[10px] text-slate-400"></i>
                                        <span>{{ ucfirst($payment->payment_method ?? 'Manual') }}</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-6 text-right">
                                    @if($payment->payment_status === 'success')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Completed</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            <span>{{ ucfirst($payment->payment_status) }}</span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto text-slate-400 text-lg mb-2">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700">No payment logs found</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Transactions from subscribers and API will appear here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
