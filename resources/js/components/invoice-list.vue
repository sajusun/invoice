<template>
    <div id="invoice" class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header & Top Stats -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Invoices</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage, issue, track, and dispatch your client invoices.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/invoice/builder" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition-all">
                        <i class="fas fa-plus mr-2 text-xs"></i>
                        New Invoice
                    </a>
                </div>
            </div>

            <!-- Stats KPI Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Invoices</span>
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-slate-900">{{ counts.all }}</div>
                    <div class="text-xs text-slate-400 mt-1">All created invoices</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Paid Invoices</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-emerald-600">{{ counts.paid }}</div>
                    <div class="text-xs text-slate-400 mt-1">Settled in full</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pending / Unpaid</span>
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-amber-600">{{ counts.unpaid }}</div>
                    <div class="text-xs text-slate-400 mt-1">Awaiting payment</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Overdue</span>
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-rose-600">{{ counts.overdue }}</div>
                    <div class="text-xs text-slate-400 mt-1">Past due date</div>
                </div>
            </div>
        </div>

        <!-- Main Card & Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <!-- Filter & Search Toolbar -->
            <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Status Filter Tabs -->
                <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
                    <button v-for="tab in ['all', 'unpaid', 'paid', 'overdue']" :key="tab"
                        @click="setStatusFilter(tab)"
                        :class="activeTab === tab ? 'bg-indigo-600 text-white font-medium shadow-sm' : 'text-slate-600 hover:bg-slate-100 font-normal'"
                        class="px-3.5 py-1.5 rounded-xl text-xs capitalize transition-all">
                        {{ tab }}
                    </button>
                </div>

                <!-- Search & Page Size Controls -->
                <div class="flex items-center gap-3">
                    <div class="relative flex-1 sm:w-64">
                        <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                        <input v-model="searchQuery" @input="debounceSearch" type="text"
                            placeholder="Search by ID, client..."
                            class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                    </div>

                    <select v-model="pageSize" @change="per_page"
                        class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-indigo-500 transition">
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                        <option value="100">100 / page</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Action Bar -->
            <div v-if="selectedIds.length > 0" class="bg-indigo-50 px-6 py-3 border-b border-indigo-100 flex items-center justify-between text-xs">
                <span class="font-medium text-indigo-900">
                    <i class="fas fa-check-square mr-1.5"></i> {{ selectedIds.length }} invoice(s) selected
                </span>
                <div class="flex items-center gap-2">
                    <button @click="bulkMarkPaid" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition shadow-sm">
                        Mark as Paid
                    </button>
                    <button @click="bulkDelete" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-lg transition shadow-sm">
                        Delete Selected
                    </button>
                    <button @click="selectedIds = []" class="px-3 py-1.5 bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition">
                        Cancel
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead class="bg-slate-50/75 text-slate-500 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center">
                                <input type="checkbox" :checked="isAllSelected" @change="toggleSelectAll" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                            </th>
                            <th class="py-3 px-4 cursor-pointer" @click="sortBy('invoice_number')">
                                Invoice # <i class="fas fa-sort ml-1 text-slate-300"></i>
                            </th>
                            <th class="py-3 px-4 cursor-pointer" @click="sortBy('customer.name')">
                                Customer <i class="fas fa-sort ml-1 text-slate-300"></i>
                            </th>
                            <th class="py-3 px-4 cursor-pointer" @click="sortBy('invoice_date')">
                                Date <i class="fas fa-sort ml-1 text-slate-300"></i>
                            </th>
                            <th class="py-3 px-4 cursor-pointer text-right" @click="sortBy('total_amount')">
                                Amount <i class="fas fa-sort ml-1 text-slate-300"></i>
                            </th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr v-if="loading" class="text-center py-12">
                            <td colspan="7" class="py-12">
                                <div class="flex items-center justify-center space-x-2 text-indigo-600 font-medium">
                                    <div class="w-5 h-5 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Loading invoices...</span>
                                </div>
                            </td>
                        </tr>

                        <tr v-else-if="filteredInvoices.length === 0" class="text-center py-12">
                            <td colspan="7" class="py-12 text-slate-400">
                                <i class="fas fa-folder-open text-3xl mb-2 block"></i>
                                No invoices found matching your criteria.
                            </td>
                        </tr>

                        <tr v-for="invoice in filteredInvoices" :key="invoice.id"
                            class="hover:bg-slate-50/75 transition-colors">
                            <td class="py-3.5 px-4 text-center">
                                <input type="checkbox" :value="invoice.invoice_number" v-model="selectedIds" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-indigo-600">
                                <a :href="'/invoice/' + invoice.invoice_number + '/preview'" class="hover:underline">
                                    #{{ invoice.invoice_number }}
                                </a>
                                <span v-if="invoice.is_recurring" title="Recurring Invoice" class="ml-1.5 px-1.5 py-0.5 rounded text-[10px] bg-indigo-50 text-indigo-700 font-sans font-normal border border-indigo-100">
                                    <i class="fas fa-sync-alt text-[9px]"></i> {{ invoice.recurring_frequency }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-900">
                                <div>{{ invoice.customer ? invoice.customer.name : 'N/A' }}</div>
                                <div class="text-[11px] text-slate-400 font-normal">{{ invoice.customer ? invoice.customer.email : '' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                <div>{{ formatDate(invoice.invoice_date) }}</div>
                                <div v-if="invoice.due_date" class="text-[11px] text-slate-400">Due: {{ formatDate(invoice.due_date) }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-right font-mono font-semibold text-slate-900">
                                {{ formatCurrency(invoice.total_amount, invoice.currency) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span :class="getStatusClass(invoice.status)" class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="getStatusDot(invoice.status)"></span>
                                    {{ (invoice.status || 'unpaid').toUpperCase() }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Preview -->
                                    <a :href="'/invoice/' + invoice.invoice_number + '/preview'" title="Preview Invoice"
                                        class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Edit -->
                                    <a :href="'/invoice/' + invoice.invoice_number + '/edit'" title="Edit Invoice"
                                        class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <!-- Send Email -->
                                    <button @click="sendEmail(invoice)" title="Send Invoice via Email"
                                        class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    <!-- Duplicate -->
                                    <button @click="duplicateInvoice(invoice)" title="Duplicate Invoice"
                                        class="p-1.5 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <!-- Delete -->
                                    <button @click="deleteInvoice(invoice)" title="Delete Invoice"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
                <div>
                    Showing <span class="font-semibold text-slate-700">{{ paginate.from || 0 }}</span>
                    to <span class="font-semibold text-slate-700">{{ paginate.to || 0 }}</span>
                    of <span class="font-semibold text-slate-700">{{ paginate.total || 0 }}</span> invoices
                </div>
                <div class="flex items-center gap-1.5">
                    <button v-for="(link, i) in paginate.links" :key="i"
                        @click="onClickLinks(link.url)"
                        v-html="link.label"
                        :disabled="!link.url"
                        :class="[
                            'px-3 py-1.5 rounded-lg border text-xs transition-colors',
                            link.active ? 'bg-indigo-600 text-white border-indigo-600 font-semibold' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50',
                            !link.url ? 'opacity-40 cursor-not-allowed' : 'cursor-pointer'
                        ]">
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const invoices = ref([])
const paginate = ref({})
const counts = ref({ all: 0, paid: 0, unpaid: 0, overdue: 0 })
const loading = ref(false)

const searchQuery = ref('')
const activeTab = ref('all')
const sortField = ref('id')
const sortDirection = ref('desc')
const pageSize = ref(10)
const selectedIds = ref([])

let debounceTimer = null

const debounceSearch = () => {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
        fetchInvoices()
    }, 300)
}

const setStatusFilter = (tab) => {
    activeTab.value = tab
    fetchInvoices()
}

const per_page = () => {
    localStorage.setItem('pageSize', pageSize.value)
    fetchInvoices()
}

const onClickLinks = (url) => {
    if (url) fetchInvoices(url)
}

const fetchInvoices = async (url = '/invoice/search') => {
    loading.value = true
    try {
        const { data } = await axios.get(url, {
            params: {
                search: searchQuery.value,
                status: activeTab.value !== 'all' ? activeTab.value : null,
                paginate: pageSize.value,
            }
        })

        if (data.invoices) {
            invoices.value = data.invoices.data || []
            paginate.value = data.invoices
        }
        if (data.status) {
            counts.value = data.status
        }
    } catch (e) {
        console.error('Failed to load invoices:', e)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    const savedSize = localStorage.getItem('pageSize')
    if (savedSize) pageSize.value = parseInt(savedSize)
    fetchInvoices()
})

const isAllSelected = computed(() => {
    return invoices.value.length > 0 && selectedIds.value.length === invoices.value.length
})

const toggleSelectAll = (e) => {
    if (e.target.checked) {
        selectedIds.value = invoices.value.map(i => i.invoice_number)
    } else {
        selectedIds.value = []
    }
}

const filteredInvoices = computed(() => {
    return invoices.value
})

const formatCurrency = (amount, curr = 'USD') => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: curr || 'USD'
    }).format(amount || 0)
}

const formatDate = (dateStr) => {
    if (!dateStr) return '-'
    const d = new Date(dateStr)
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}

const getStatusClass = (st) => {
    const s = (st || '').toLowerCase()
    if (s === 'paid') return 'bg-emerald-50 text-emerald-700 border border-emerald-200/60'
    if (s === 'overdue') return 'bg-rose-50 text-rose-700 border border-rose-200/60'
    if (s === 'draft') return 'bg-slate-100 text-slate-700 border border-slate-200'
    return 'bg-amber-50 text-amber-700 border border-amber-200/60'
}

const getStatusDot = (st) => {
    const s = (st || '').toLowerCase()
    if (s === 'paid') return 'bg-emerald-500'
    if (s === 'overdue') return 'bg-rose-500'
    if (s === 'draft') return 'bg-slate-400'
    return 'bg-amber-500'
}

const sortBy = (field) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortField.value = field
        sortDirection.value = 'asc'
    }
}

const sendEmail = async (invoice) => {
    const customerEmail = invoice.customer ? invoice.customer.email : ''
    if (!customerEmail) {
        alert('Customer email address is not configured.')
        return
    }

    if (!confirm(`Send invoice #${invoice.invoice_number} to ${customerEmail}?`)) {
        return
    }

    try {
        const { data } = await axios.post(`/invoice/${invoice.invoice_number}/send-email`, {
            attach_pdf: true
        })

        if (data.success) {
            alert(data.message || 'Invoice sent successfully!')
        } else {
            alert(data.message || 'Failed to send invoice email.')
        }
    } catch (e) {
        alert(e.response?.data?.message || 'Error sending invoice email.')
    }
}

const duplicateInvoice = async (invoice) => {
    if (!confirm(`Duplicate invoice #${invoice.invoice_number}?`)) {
        return
    }

    try {
        const { data } = await axios.post(`/invoice/${invoice.invoice_number}/duplicate`)
        if (data.success) {
            alert(data.message || 'Invoice duplicated successfully!')
            fetchInvoices()
        }
    } catch (e) {
        alert(e.response?.data?.message || 'Error duplicating invoice.')
    }
}

const deleteInvoice = async (invoice) => {
    if (!confirm(`Are you sure you want to delete invoice #${invoice.invoice_number}?`)) {
        return
    }

    try {
        await axios.post(`/invoice/${invoice.invoice_number}/delete`)
        fetchInvoices()
    } catch (e) {
        alert('Error deleting invoice.')
    }
}

const bulkMarkPaid = async () => {
    if (!confirm(`Mark ${selectedIds.value.length} selected invoices as Paid?`)) return

    try {
        const { data } = await axios.post('/invoice/bulk-action', {
            action: 'mark_paid',
            invoice_numbers: selectedIds.value
        })
        selectedIds.value = []
        fetchInvoices()
    } catch (e) {
        alert('Bulk action failed.')
    }
}

const bulkDelete = async () => {
    if (!confirm(`Delete ${selectedIds.value.length} selected invoices permanently?`)) return

    try {
        const { data } = await axios.post('/invoice/bulk-action', {
            action: 'delete',
            invoice_numbers: selectedIds.value
        })
        selectedIds.value = []
        fetchInvoices()
    } catch (e) {
        alert('Bulk delete failed.')
    }
}
</script>
