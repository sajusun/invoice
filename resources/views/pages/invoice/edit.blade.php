<x-dashboard-layout>
    <x-slot name="title">Edit Invoice #{{ $invoice->invoice_number }} - Invozen</x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="invoiceEditor()">
        <!-- Top Action Bar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <a href="{{ route('invoices') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-2">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Invoices
                </a>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center gap-3">
                    Edit Invoice <span class="text-indigo-600 font-mono">#{{ $invoice->invoice_number }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider
                        @if($invoice->status === 'paid') bg-emerald-100 text-emerald-800 border border-emerald-200
                        @elseif($invoice->status === 'overdue') bg-rose-100 text-rose-800 border border-rose-200
                        @else bg-amber-100 text-amber-800 border border-amber-200 @endif">
                        {{ $invoice->status }}
                    </span>
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('previewInvoice', $invoice->invoice_number) }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-xl text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
                    <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Preview
                </a>
                <button type="button" @click="saveInvoice()" :disabled="saving" class="inline-flex items-center px-5 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 transition shadow-md shadow-indigo-200 disabled:opacity-50">
                    <svg x-show="saving" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    <span x-text="saving ? 'Saving...' : 'Save Changes'"></span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Invoice Details & Line Items -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer & Dates Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-semibold text-slate-900 border-b border-slate-100 pb-3">Bill To & Schedule</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Customer Name</label>
                            <input type="text" x-model="form.customer_name" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="Customer name" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Customer Email</label>
                            <input type="email" x-model="form.customer_email" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="customer@example.com" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Invoice Date</label>
                            <input type="date" x-model="form.invoice_date" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Due Date</label>
                            <input type="date" x-model="form.due_date" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>
                    </div>
                </div>

                <!-- Line Items Table -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="text-base font-semibold text-slate-900">Line Items</h2>
                        <button type="button" @click="addItem()" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Item
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead>
                                <tr class="text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                                    <th class="py-2.5 px-2">Description</th>
                                    <th class="py-2.5 px-2 w-24 text-center">Qty</th>
                                    <th class="py-2.5 px-2 w-32 text-right">Rate</th>
                                    <th class="py-2.5 px-2 w-32 text-right">Amount</th>
                                    <th class="py-2.5 px-2 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(item, idx) in form.items" :key="idx">
                                    <tr>
                                        <td class="py-3 px-2">
                                            <input type="text" x-model="item.name" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="Item description" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="number" step="any" min="0" x-model.number="item.qty" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-center focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="number" step="0.01" min="0" x-model.number="item.rate" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-right focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                                        </td>
                                        <td class="py-3 px-2 text-right font-medium text-slate-900 font-mono" x-text="formatMoney(item.qty * item.rate)"></td>
                                        <td class="py-3 px-2 text-center">
                                            <button type="button" @click="removeItem(idx)" class="text-slate-400 hover:text-rose-600 transition" :disabled="form.items.length <= 1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Notes & Terms -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-semibold text-slate-900 border-b border-slate-100 pb-3">Notes & Payment Terms</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Notes</label>
                            <textarea rows="3" x-model="form.notes" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="Thank you for your business!"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Terms & Conditions</label>
                            <textarea rows="3" x-model="form.terms" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" placeholder="Payment is due within 30 days."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary & Settings Sidebar -->
            <div class="space-y-6">
                <!-- Status & Totals Card -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-semibold text-slate-900 border-b border-slate-100 pb-3">Status & Calculation</h2>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Payment Status</label>
                        <select x-model="form.status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                            <option value="partially_paid">Partially Paid</option>
                            <option value="overdue">Overdue</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Tax (%)</label>
                            <input type="number" step="0.01" min="0" x-model.number="form.tax_percentage" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Discount ($)</label>
                            <input type="number" step="0.01" min="0" x-model.number="form.discount_amount" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 space-y-2.5 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal:</span>
                            <span class="font-medium font-mono" x-text="formatMoney(calculateSubtotal())"></span>
                        </div>
                        <div class="flex justify-between text-slate-600" x-show="form.tax_percentage > 0">
                            <span>Tax (<span x-text="form.tax_percentage"></span>%):</span>
                            <span class="font-medium font-mono text-emerald-600" x-text="formatMoney(calculateTax())"></span>
                        </div>
                        <div class="flex justify-between text-slate-600" x-show="form.discount_amount > 0">
                            <span>Discount:</span>
                            <span class="font-medium font-mono text-rose-600" x-text="'-' + formatMoney(form.discount_amount)"></span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-slate-900 border-t border-slate-200 pt-3">
                            <span>Total Due:</span>
                            <span class="text-indigo-600 font-mono" x-text="formatMoney(calculateTotal())"></span>
                        </div>
                    </div>
                </div>

                <!-- Recurring Invoice Schedule -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-slate-900">Recurring Schedule</label>
                        <input type="checkbox" x-model="form.is_recurring" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
                    </div>

                    <div x-show="form.is_recurring" x-transition class="space-y-3 pt-2">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Frequency</label>
                            <select x-model="form.recurring_frequency" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">End Date (Optional)</label>
                            <input type="date" x-model="form.recurring_end_date" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function invoiceEditor() {
            return {
                saving: false,
                form: {
                    customer_name: @json($invoice->customer?->name ?? ''),
                    customer_email: @json($invoice->customer?->email ?? ''),
                    invoice_date: @json($invoice->invoice_date?->format('Y-m-d') ?? now()->format('Y-m-d')),
                    due_date: @json($invoice->due_date?->format('Y-m-d') ?? ''),
                    status: @json($invoice->status ?? 'unpaid'),
                    items: @json($invoice->items ?? [['name' => 'Service', 'qty' => 1, 'rate' => 100]]),
                    tax_percentage: 0,
                    discount_amount: @json((float)$invoice->discount_amount),
                    notes: @json($invoice->notes ?? ''),
                    terms: @json($invoice->terms ?? ''),
                    is_recurring: @json((bool)$invoice->is_recurring),
                    recurring_frequency: @json($invoice->recurring_frequency ?? 'monthly'),
                    recurring_end_date: @json($invoice->recurring_end_date?->format('Y-m-d') ?? ''),
                },
                addItem() {
                    this.form.items.push({ name: '', qty: 1, rate: 0 });
                },
                removeItem(idx) {
                    if (this.form.items.length > 1) {
                        this.form.items.splice(idx, 1);
                    }
                },
                calculateSubtotal() {
                    return this.form.items.reduce((acc, it) => acc + ((parseFloat(it.qty) || 0) * (parseFloat(it.rate) || 0)), 0);
                },
                calculateTax() {
                    const subtotal = this.calculateSubtotal();
                    return (subtotal * (parseFloat(this.form.tax_percentage) || 0)) / 100;
                },
                calculateTotal() {
                    const subtotal = this.calculateSubtotal();
                    const tax = this.calculateTax();
                    const discount = parseFloat(this.form.discount_amount) || 0;
                    return Math.max(0, subtotal + tax - discount);
                },
                formatMoney(amount) {
                    return '$' + (parseFloat(amount) || 0).toFixed(2);
                },
                async saveInvoice() {
                    this.saving = true;
                    try {
                        const res = await fetch('{{ route("invoice.update", $invoice->invoice_number) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });
                        const data = await res.json();
                        if (data.success) {
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                            if (data.redirect) {
                                setTimeout(() => window.location.href = data.redirect, 1000);
                            }
                        } else {
                            alert(data.message || 'Error updating invoice');
                        }
                    } catch (e) {
                        alert('Failed to save invoice: ' + e.message);
                    } finally {
                        this.saving = false;
                    }
                }
            }
        }
    </script>
</x-dashboard-layout>
