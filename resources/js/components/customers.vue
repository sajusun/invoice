<template>
    <div id="customers" class="container mx-auto px-4 py-6 max-w-7xl">
        <!-- Header & Top Stats -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Clients Directory</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage your customer relationships, client billing records, and contact directories.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/dashboard/customers/add" class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 shadow-md shadow-indigo-200 transition-all">
                        <i class="fas fa-user-plus mr-2 text-xs"></i>
                        New Client
                    </a>
                </div>
            </div>

            <!-- Stats KPI Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Clients</span>
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-slate-900">{{ counts.total || 0 }}</div>
                    <div class="text-xs text-slate-400 mt-1">Registered clients</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">New Clients</span>
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-emerald-600">{{ counts.new || 0 }}</div>
                    <div class="text-xs text-slate-400 mt-1">Added this month</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Unpaid Invoices</span>
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-amber-600">{{ counts.unpaid || 0 }}</div>
                    <div class="text-xs text-slate-400 mt-1">Clients with balance</div>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Overdue Alerts</span>
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="text-2xl font-bold text-rose-600">{{ counts.overdue || 0 }}</div>
                    <div class="text-xs text-slate-400 mt-1">Past payment terms</div>
                </div>
            </div>
        </div>

        <!-- Main Card & Data Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <!-- Search & Controls Toolbar -->
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="relative flex-1 sm:max-w-md">
                    <i class="fas fa-search absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input v-model="searchQuery" @input="debounceSearch" type="text"
                        placeholder="Search by name, company, email, phone..."
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-indigo-500 focus:bg-white transition" />
                </div>

                <div class="flex items-center gap-3">
                    <select v-model="pageSize" @change="per_page"
                        class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:ring-2 focus:ring-indigo-500 transition">
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                        <option value="100">100 / page</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                    <thead class="bg-slate-50/75 text-slate-500 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center">#</th>
                            <th class="py-3 px-4 cursor-pointer" @click="sortBy('name')">
                                Client / Company <i class="fas fa-sort ml-1 text-slate-300"></i>
                            </th>
                            <th class="py-3 px-4 cursor-pointer" @click="sortBy('email')">
                                Contact Info <i class="fas fa-sort ml-1 text-slate-300"></i>
                            </th>
                            <th class="py-3 px-4">Address</th>
                            <th class="py-3 px-4 text-center">Invoices</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr v-if="loading" class="text-center py-12">
                            <td colspan="6" class="py-12">
                                <div class="flex items-center justify-center space-x-2 text-indigo-600 font-medium">
                                    <div class="w-5 h-5 border-2 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                                    <span>Loading clients directory...</span>
                                </div>
                            </td>
                        </tr>

                        <tr v-else-if="customers.length === 0" class="text-center py-12">
                            <td colspan="6" class="py-12 text-slate-400">
                                <i class="fas fa-users-slash text-3xl mb-2 block"></i>
                                No clients found matching your search.
                            </td>
                        </tr>

                        <tr v-for="(client, index) in customers" :key="client.id"
                            class="hover:bg-slate-50/75 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ (currentPage - 1) * pageSize + index + 1 }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white font-semibold flex items-center justify-center text-xs uppercase shadow-sm">
                                        {{ (client.name || 'C').charAt(0) }}
                                    </div>
                                    <div>
                                        <a :href="'/dashboard/customers/' + client.id + '/view'" class="font-semibold text-slate-900 hover:text-indigo-600 transition-colors">
                                            {{ client.name }}
                                        </a>
                                        <div v-if="client.company_name" class="text-[11px] text-slate-400">
                                            <i class="fas fa-building text-[10px] mr-1"></i>{{ client.company_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-mono text-slate-700">{{ client.email || '—' }}</div>
                                <div v-if="client.phone" class="text-[11px] text-slate-400">{{ client.phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 max-w-xs truncate">
                                {{ client.address || '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ client.invoices_count || 0 }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- View Details -->
                                    <a :href="'/dashboard/customers/' + client.id + '/view'" title="Client Dashboard & Invoices"
                                        class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Update -->
                                    <a :href="'/dashboard/customers/' + client.id + '/update'" title="Edit Profile"
                                        class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <!-- Delete -->
                                    <button @click="deleteCustomer(client)" title="Delete Client"
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
                    of <span class="font-semibold text-slate-700">{{ paginate.total || 0 }}</span> clients
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
import { ref, onMounted } from 'vue'
import axios from 'axios'

const customers = ref([])
const paginate = ref({})
const counts = ref({ total: 0, new: 0, unpaid: 0, overdue: 0 })
const loading = ref(false)

const searchQuery = ref('')
const sortField = ref('name')
const sortDirection = ref('asc')
const currentPage = ref(1)
const pageSize = ref(10)

let debounceTimer = null

const debounceSearch = () => {
    clearTimeout(debounceTimer)
    debounceTimer = setTimeout(() => {
        fetchCustomers()
    }, 300)
}

const per_page = () => {
    localStorage.setItem('customer_pageSize', pageSize.value)
    fetchCustomers()
}

const onClickLinks = (url) => {
    if (url) fetchCustomers(url)
}

const fetchCustomers = async (url = '/dashboard/customers/search') => {
    loading.value = true
    try {
        const { data } = await axios.get(url, {
            params: {
                search: searchQuery.value,
                paginate: pageSize.value,
            }
        })

        if (data.customers) {
            customers.value = data.customers.data || []
            paginate.value = data.customers
            currentPage.value = data.customers.current_page || 1
        }
        if (data.status) {
            counts.value = data.status
        }
    } catch (e) {
        console.error('Failed to load customers:', e)
    } finally {
        loading.value = false
    }
}

onMounted(() => {
    const savedSize = localStorage.getItem('customer_pageSize')
    if (savedSize) pageSize.value = parseInt(savedSize)
    fetchCustomers()
})

const sortBy = (field) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
        sortField.value = field
        sortDirection.value = 'asc'
    }
}

const deleteCustomer = async (client) => {
    if (!confirm(`Are you sure you want to delete client "${client.name}"? This may affect linked invoices.`)) {
        return
    }

    try {
        await axios.post(`/customers/${client.id}/delete`)
        fetchCustomers()
    } catch (e) {
        alert('Error deleting client.')
    }
}
</script>
