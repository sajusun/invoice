
<script>
import axios from "axios";

export default {
    name: "InvoiceBuilder",
    data() {
        return {
            invoice: {
                business: { name: "", email: "", address: "", phone: "", website: "" },
                client: { name: "", contact: "", email: "", phone: "", address: "" },
                details: { number: "INV-2024-001", issueDate: "", dueDate: "" },
                items: [{ description: "", qty: 1, rate: 0 }],
                notes: "",
                terms: "",
            },
        };
    },
    computed: {
        subtotal() {
            return this.invoice.items.reduce((sum, i) => sum + i.qty * i.rate, 0);
        },
        tax() {
            return this.subtotal * 0.1; // 10%
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
            this.invoice.items.splice(index, 1);
        },
        previewInvoice() {
            console.log("Preview invoice:", this.invoice);
            alert("Invoice preview logged to console.");
        },
        async saveDraft() {
          let data=  await window.axios.post("/invoice/create", this.invoice);
console.log(data);

        },
        async sendInvoice() {
            await axios.post("/invoice/create", this.invoice);

        },
        exportPdf() {

        },
    },
};
</script>
<template>
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Invoice</h1>
            <p class="text-gray-600">Build professional invoices in minutes with our smart invoice builder</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Invoice Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Business Info -->
                <section class="bg-white rounded-xl p-6 invoice-shadow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Your Business Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input v-model="invoice.business.name" type="text" class="input-field" placeholder="Your Company Name" />
                        <input v-model="invoice.business.email" type="email" class="input-field" placeholder="business@company.com" />
                        <textarea v-model="invoice.business.address" rows="3" class="input-field md:col-span-2" placeholder="Your business address"></textarea>
                        <input v-model="invoice.business.phone" type="tel" class="input-field" placeholder="+1 (555) 123-4567" />
                        <input v-model="invoice.business.website" type="url" class="input-field" placeholder="www.yourcompany.com" />
                    </div>
                </section>

                <!-- Client Info -->
                <section class="bg-white rounded-xl p-6 invoice-shadow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Bill To</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input v-model="invoice.client.name" type="text" class="input-field" placeholder="Client Company" />
                        <input v-model="invoice.client.contact" type="text" class="input-field" placeholder="John Smith" />
                        <input v-model="invoice.client.email" type="email" class="input-field" placeholder="client@company.com" />
                        <input v-model="invoice.client.phone" type="tel" class="input-field" placeholder="+1 (555) 987-6543" />
                        <textarea v-model="invoice.client.address" rows="3" class="input-field md:col-span-2" placeholder="Client billing address"></textarea>
                    </div>
                </section>

                <!-- Invoice Details -->
                <section class="bg-white rounded-xl p-6 invoice-shadow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Invoice Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input v-model="invoice.details.number" type="text" class="input-field" placeholder="INV-2024-001" />
                        <input v-model="invoice.details.issueDate" type="date" class="input-field" />
                        <input v-model="invoice.details.dueDate" type="date" class="input-field" />
                    </div>
                </section>

                <!-- Line Items -->
                <section class="bg-white rounded-xl p-6 invoice-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Items & Services</h2>
                        <button @click="addItem" class="btn-primary">+ Add Item</button>
                    </div>

                    <div v-for="(item, index) in invoice.items" :key="index" class="item-row grid grid-cols-12 gap-3 mb-3 items-end">
                        <input v-model="item.description" class="col-span-5 input-field" placeholder="Description" />
                        <input v-model.number="item.qty" type="number" class="col-span-2 input-field" />
                        <input v-model.number="item.rate" type="number" step="0.01" class="col-span-2 input-field" />
                        <input :value="(item.qty * item.rate).toFixed(2)" readonly class="col-span-2 input-field bg-gray-50" />
                        <button @click="removeItem(index)" class="col-span-1 text-red-500 hover:text-red-700">🗑</button>
                    </div>
                </section>

                <!-- Notes & Terms -->
                <section class="bg-white rounded-xl p-6 invoice-shadow">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Additional Information</h2>
                    <textarea v-model="invoice.notes" rows="3" class="input-field" placeholder="Any additional notes or comments"></textarea>
                    <textarea v-model="invoice.terms" rows="3" class="input-field mt-4" placeholder="Payment terms and conditions"></textarea>
                </section>
            </div>

            <!-- Invoice Summary & Actions -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-xl p-6 invoice-shadow sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Summary</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal:</span>
                            <span class="font-medium">${{ subtotal.toFixed(2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Tax (10%):</span>
                            <span class="font-medium">${{ tax.toFixed(2) }}</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total:</span>
                                <span class="text-indigo-600">${{ total.toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button @click="previewInvoice" class="btn-secondary">👁 Preview Invoice</button>
                        <button @click="saveDraft" class="btn-green">💾 Save Draft</button>
                        <button @click="sendInvoice" class="btn-blue">📩 Send Invoice</button>
                        <button @click="exportPdf" class="btn-outline">⬇ Export PDF</button>
                    </div>
                </div>
            </aside>
        </div>
    </main>
</template>



<style>
.input-field {
    @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent;
}
.btn-primary {
    @apply bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition;
}
.btn-secondary {
    @apply w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition;
}
.btn-green {
    @apply w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition;
}
.btn-blue {
    @apply w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition;
}
.btn-outline {
    @apply w-full border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition;
}
</style>

