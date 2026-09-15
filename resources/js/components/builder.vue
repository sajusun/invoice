<script>
import axios from "axios";

export default {
    name: "InvoiceBuilder",
    props: {
        initialSettings: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        const today = new Date().toISOString().split('T')[0];
        const due = new Date(Date.now() + 14 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
        const randomNum = 'INV-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);

        return {
            loading: false,
            successMessage: '',
            errorMessage: '',
            taxPercentage: 10,
            currency: '$',
            invoice: {
                business: { name: "", email: "", address: "", phone: "", website: "" },
                client: { name: "", contact: "", email: "", phone: "", address: "" },
                details: { number: randomNum, issueDate: today, dueDate: due },
                items: [
                    { description: "Website Design & Development", qty: 1, rate: 500 }
                ],
                notes: "Thank you for your business. Payment is expected within 14 days of invoice date.",
                terms: "Please send payment via bank transfer or online payment link.",
            },
        };
    },
    computed: {
        subtotal() {
            return this.invoice.items.reduce((sum, i) => sum + (Number(i.qty) || 0) * (Number(i.rate) || 0), 0);
        },
        tax() {
            return (this.subtotal * (Number(this.taxPercentage) || 0)) / 100;
        },
        total() {
            return this.subtotal + this.tax;
        },
    },
    methods: {
        addItem() {
            this.invoice.items.push({ description: "", qty: 1, rate: 0 });
        },
        removeItem(index) {
            if (this.invoice.items.length > 1) {
                this.invoice.items.splice(index, 1);
            }
        },
        async saveInvoice(isDraft = false) {
            this.loading = true;
            this.errorMessage = '';
            this.successMessage = '';

            try {
                const payload = {
                    ...this.invoice,
                    currency: this.currency,
                    tax_percentage: this.taxPercentage,
                    paid_amount: isDraft ? 0 : 0,
                    status: isDraft ? 'draft' : 'unpaid'
                };

                const res = await axios.post("/invoice/create", payload);
                if (res.data && res.data.success) {
                    this.successMessage = res.data.message || 'Invoice generated successfully!';
                    if (res.data.redirect) {
                        setTimeout(() => {
                            window.location.href = res.data.redirect;
                        }, 700);
                    }
                } else {
                    this.errorMessage = res.data.message || 'Could not save invoice.';
                }
            } catch (err) {
                this.errorMessage = err.response?.data?.message || 'Failed to save invoice. Please verify the fields.';
            } finally {
                this.loading = false;
            }
        }
    },
};
</script>

<template>
    <div class="space-y-6">
        <!-- Notification Alert -->
        <div v-if="successMessage" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ successMessage }}</span>
        </div>
        <div v-if="errorMessage" class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center gap-3">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
            <span>{{ errorMessage }}</span>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900">Invoice Studio & Builder</h1>
                <p class="text-sm text-slate-500 mt-0.5">Generate professional invoices with auto-tax, customer linking, and one-click PDF generation.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/60">
                    <i class="fa-solid fa-bolt mr-1.5 text-blue-600"></i> Auto Calculation
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Business Details -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold">1</div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Your Business Details (Issuer)</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Company / Issuer Name</label>
                            <input v-model="invoice.business.name" type="text" class="form-input" placeholder="e.g. Acme Corp" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Business Email</label>
                            <input v-model="invoice.business.email" type="email" class="form-input" placeholder="billing@acme.com" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Street Address</label>
                            <input v-model="invoice.business.address" type="text" class="form-input" placeholder="123 Tech Blvd, Suite 400" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                            <input v-model="invoice.business.phone" type="tel" class="form-input" placeholder="+1 (555) 019-2834" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Website</label>
                            <input v-model="invoice.business.website" type="url" class="form-input" placeholder="https://acme.com" />
                        </div>
                    </div>
                </div>

                <!-- Client Details -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">2</div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Client Details (Bill To)</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Client Company / Name *</label>
                            <input v-model="invoice.client.name" type="text" class="form-input" placeholder="Client Name / Organization" required />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Contact Person</label>
                            <input v-model="invoice.client.contact" type="text" class="form-input" placeholder="e.g. John Doe" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Client Email</label>
                            <input v-model="invoice.client.email" type="email" class="form-input" placeholder="client@domain.com" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Client Phone</label>
                            <input v-model="invoice.client.phone" type="tel" class="form-input" placeholder="+1 (555) 345-6789" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Client Address</label>
                            <input v-model="invoice.client.address" type="text" class="form-input" placeholder="Client street address, city, country" />
                        </div>
                    </div>
                </div>

                <!-- Invoice Meta & Items -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs font-bold">3</div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Invoice Details & Line Items</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Invoice Number</label>
                            <input v-model="invoice.details.number" type="text" class="form-input font-mono font-bold text-blue-600" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Issue Date</label>
                            <input v-model="invoice.details.issueDate" type="date" class="form-input" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Due Date</label>
                            <input v-model="invoice.details.dueDate" type="date" class="form-input" />
                        </div>
                    </div>

                    <!-- Line Items Table -->
                    <div class="space-y-3 pt-2">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-600">Line Items</label>
                            <button @click="addItem" type="button" class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors cursor-pointer">
                                <i class="fa-solid fa-plus text-xs"></i> Add Item
                            </button>
                        </div>

                        <div class="space-y-2.5">
                            <div v-for="(item, index) in invoice.items" :key="index"
                                 class="p-3.5 bg-slate-50/80 rounded-xl border border-slate-200/80 grid grid-cols-12 gap-3 items-center">
                                <div class="col-span-12 sm:col-span-6">
                                    <input v-model="item.description" class="form-input bg-white" placeholder="Item / Service description" />
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <input v-model.number="item.qty" type="number" min="1" class="form-input bg-white text-center" placeholder="Qty" />
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <input v-model.number="item.rate" type="number" step="0.01" min="0" class="form-input bg-white text-right" placeholder="Rate" />
                                </div>
                                <div class="col-span-3 sm:col-span-1 text-right font-bold text-xs text-slate-700">
                                    {{ currency }}{{ ((Number(item.qty) || 0) * (Number(item.rate) || 0)).toFixed(2) }}
                                </div>
                                <div class="col-span-1 text-right">
                                    <button @click="removeItem(index)" type="button" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" title="Delete row">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes & Terms -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-bold">4</div>
                        <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Notes & Payment Terms</h2>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Customer Notes</label>
                            <textarea v-model="invoice.notes" rows="2" class="form-input" placeholder="Additional notes for your customer..."></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Terms & Conditions</label>
                            <textarea v-model="invoice.terms" rows="2" class="form-input" placeholder="Payment terms, bank account, transfer instructions..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Summary Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm sticky top-20 space-y-6">
                    <h3 class="text-sm font-black uppercase tracking-wider text-slate-900 pb-3 border-b border-slate-100">
                        Invoice Summary
                    </h3>

                    <!-- Currency & Tax Controls -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Currency</label>
                            <select v-model="currency" class="form-input">
                                <option value="$">USD ($)</option>
                                <option value="€">EUR (€)</option>
                                <option value="£">GBP (£)</option>
                                <option value="৳">BDT (৳)</option>
                                <option value="₹">INR (₹)</option>
                                <option value="C$">CAD (C$)</option>
                                <option value="A$">AUD (A$)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Tax Rate (%)</label>
                            <input v-model.number="taxPercentage" type="number" min="0" max="100" class="form-input text-right" />
                        </div>
                    </div>

                    <!-- Breakdown -->
                    <div class="space-y-2.5 p-4 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal:</span>
                            <span class="font-bold text-slate-900">{{ currency }}{{ subtotal.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Estimated Tax ({{ taxPercentage }}%):</span>
                            <span class="font-bold text-slate-900">{{ currency }}{{ tax.toFixed(2) }}</span>
                        </div>
                        <div class="pt-3 border-t border-slate-200/80 flex justify-between items-baseline">
                            <span class="text-sm font-black text-slate-900">Total Amount:</span>
                            <span class="text-xl font-black text-blue-600">{{ currency }}{{ total.toFixed(2) }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3 pt-2">
                        <button @click="saveInvoice(false)"
                                :disabled="loading"
                                type="button"
                                class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-extrabold rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition-all cursor-pointer disabled:opacity-50">
                            <i v-if="loading" class="fa-solid fa-circle-notch fa-spin"></i>
                            <i v-else class="fa-solid fa-paper-plane"></i>
                            <span>{{ loading ? 'Saving Invoice...' : 'Generate & Issue Invoice' }}</span>
                        </button>

                        <button @click="saveInvoice(true)"
                                :disabled="loading"
                                type="button"
                                class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-colors cursor-pointer disabled:opacity-50">
                            <i class="fa-solid fa-floppy-disk text-slate-500"></i>
                            <span>Save as Draft</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.form-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.8125rem;
    color: #1e293b;
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 0.75rem;
    outline: none;
    transition: all 0.15s ease-in-out;
}
.form-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>


