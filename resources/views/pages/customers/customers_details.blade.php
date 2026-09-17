<x-dashboard-layout>
    <x-slot name="title">Client: {{ $customer->name }} - Invozen</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Top Navigation -->
        <div class="mb-6">
            <a href="{{ route('customers') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-3">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Clients Directory
            </a>
            
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-indigo-700 text-white font-bold text-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                            {{ $customer->name }}
                        </h1>
                        <p class="text-sm text-slate-500">
                            @if($customer->company_name)
                                <span class="font-medium text-slate-700"><i class="fas fa-building text-xs mr-1 text-slate-400"></i>{{ $customer->company_name }}</span> &bull;
                            @endif
                            Client since {{ $customer->created_at->format('M Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/invoice/builder?customer_id={{ $customer->id }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition">
                        <i class="fas fa-plus mr-2 text-xs"></i>
                        Create Invoice
                    </a>
                </div>
            </div>
        </div>

        <!-- Success & Error Alerts -->
        @if(session('message'))
            <div class="mb-6 p-4 rounded-xl text-sm font-medium {{ session('response') === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-rose-50 text-rose-800 border border-rose-200' }}">
                {{ session('message') }}
            </div>
        @endif

        <!-- Financial KPI Metrics -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Invoices</span>
                <div class="text-2xl font-bold text-slate-900 mt-2">{{ $metrics['total_invoices'] ?? 0 }}</div>
                <div class="text-xs text-slate-400 mt-1">Issued to date</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Billed</span>
                <div class="text-2xl font-bold text-slate-900 mt-2">${{ number_format($metrics['total_billed'] ?? 0, 2) }}</div>
                <div class="text-xs text-slate-400 mt-1">Cumulative invoices</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Paid</span>
                <div class="text-2xl font-bold text-emerald-600 mt-2">${{ number_format($metrics['total_paid'] ?? 0, 2) }}</div>
                <div class="text-xs text-slate-400 mt-1">Revenue collected</div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Outstanding Due</span>
                <div class="text-2xl font-bold {{ ($metrics['total_due'] ?? 0) > 0 ? 'text-amber-600' : 'text-slate-900' }} mt-2">
                    ${{ number_format($metrics['total_due'] ?? 0, 2) }}
                </div>
                <div class="text-xs text-slate-400 mt-1">{{ $metrics['unpaid_count'] ?? 0 }} pending invoices</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Client Profile & Edit Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
                    <h2 class="text-base font-semibold text-slate-900 border-b border-slate-100 pb-3 mb-5">Client Profile</h2>

                    <form method="POST" action="{{ route('customers.update', $customer->id) }}" class="space-y-4 text-xs">
                        @csrf
                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>

                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Company Name</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $customer->company_name) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>

                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>

                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Phone Number *</label>
                            <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>

                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Tax / VAT ID</label>
                            <input type="text" name="tax_id" value="{{ old('tax_id', $customer->tax_id) }}"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>

                        <div>
                            <label class="block font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Billing Address</label>
                            <textarea name="address" rows="3"
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">{{ old('address', $customer->address) }}</textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-sm">
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Invoices Linked to this Customer -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-semibold text-slate-900">Invoices History</h2>
                            <p class="text-xs text-slate-500 mt-0.5">All billing statements issued to {{ $customer->name }}.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                            <thead class="bg-slate-50/75 text-slate-500 font-semibold uppercase tracking-wider">
                                <tr>
                                    <th class="py-3 px-4">Invoice #</th>
                                    <th class="py-3 px-4">Date</th>
                                    <th class="py-3 px-4 text-right">Amount</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($customer->invoices as $inv)
                                    <tr class="hover:bg-slate-50/75 transition-colors">
                                        <td class="py-3.5 px-4 font-mono font-semibold text-indigo-600">
                                            <a href="{{ route('previewInvoice', $inv->invoice_number) }}" class="hover:underline">
                                                #{{ $inv->invoice_number }}
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-500">
                                            {{ $inv->invoice_date?->format('M d, Y') ?? '—' }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-mono font-semibold text-slate-900">
                                            ${{ number_format($inv->total_amount, 2) }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold uppercase tracking-wide
                                                @if($inv->status === 'paid') bg-emerald-50 text-emerald-700 border border-emerald-200/60
                                                @elseif($inv->status === 'overdue') bg-rose-50 text-rose-700 border border-rose-200/60
                                                @else bg-amber-50 text-amber-700 border border-amber-200/60 @endif">
                                                {{ $inv->status }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                            <a href="{{ route('previewInvoice', $inv->invoice_number) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 rounded-lg transition inline-block">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('invoice.edit', $inv->invoice_number) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 rounded-lg transition inline-block">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-slate-400">
                                            <i class="fas fa-file-invoice text-3xl mb-2 block"></i>
                                            No invoices issued to this client yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
