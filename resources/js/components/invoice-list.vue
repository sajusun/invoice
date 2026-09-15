<template>
    <div id="invoice" class="container mx-auto px-4 py-4">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                        <p class="text-2xl font-bold text-gray-900">{{ status.all }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Paid</p>
                        <p class="text-2xl font-bold text-gray-900">{{ status.paid }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Unpaid</p>
                        <p class="text-2xl font-bold text-gray-900">{{ status.unpaid }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Overdue</p>
                        <p class="text-2xl font-bold text-gray-900">{{ status.overdue }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <select name="paginate" id="paginate" v-model="pageSize" @change="per_page"
                        class="border-gray-300 text-gray-700 text-sm hover:bg-gray-50">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <div class="relative">
                            <input v-model="searchQuery" @keydown.enter="onTypeKey" type="text"
                                placeholder="Search invoices..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>

                        </div>
                        <a href="/invoice/builder" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            New Invoice
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('id')">
                                #
                                <i class="fas fa-sort ml-1" :class="sortIcon('id')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('invoice_number')">
                                Invoice ID
                                <i class="fas fa-sort ml-1" :class="sortIcon('invoice_number')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('customer.name')">
                                Customer Name
                                <i class="fas fa-sort ml-1" :class="sortIcon('customer.name')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('invoice_date')">
                                Created At
                                <i class="fas fa-sort ml-1" :class="sortIcon('invoice_date')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('total_amount')">
                                Total Amount
                                <i class="fas fa-sort ml-1" :class="sortIcon('total_amount')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('paid_amount')">
                                Paid Amount
                                <i class="fas fa-sort ml-1" :class="sortIcon('paid_amount')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('status')">
                                Status
                                <i class="fas fa-sort ml-1" :class="sortIcon('status')"></i>
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(invoice, index) in filteredInvoices" :key="invoice.id"
                            class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ (currentPage - 1) * pageSize + index + 1 }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                {{ invoice.invoice_number }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ invoice.customer.name }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ formatDate(invoice.invoice_date) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ formatCurrency(invoice.total_amount) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ formatCurrency(invoice.paid_amount) }}
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap">
                                <span
                                    :class="`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusClass(invoice.status)}`">
                                    <i :class="`${getStatusIcon(invoice.status)} mr-1`"></i>
                                    {{ invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1) }}
                                </span>
                            </td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a :href="view(invoice.invoice_number)"
                                        class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                </a>
                                    <button @click="editInvoice(invoice)"
                                        class="text-green-600 hover:text-green-900 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="downloadInvoice(invoice)"
                                        class="text-purple-600 hover:text-purple-900 transition-colors"
                                        title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button @click="deleteInvoice(invoice.id)"
                                        class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="invoices.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No invoices found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-700 mb-4 md:mb-0">
                       Showing <span class="font-medium">{{ paginate.from }}</span>
                        to <span class="font-medium">{{ paginate.to }}</span>
                        of <span class="font-medium">{{ paginate.total }}</span> results
                    </div>
                    <div class="flex space-x-2">
                        <div class="flex space-x-2">
                            <button v-for="link in paginate.links" :key="link.label" @click="onClickLinks(link.url)"
                                v-html="link.label" :disabled="link.url === null" :class="`px-2 py-1 border rounded-md text-xm
            ${link.active ? 'border-blue-500 bg-blue-50 text-blue-600' : ''}
            ${link.url === null ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50'}`">
                            </button>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

let invoices = ref([]);
let paginate = ref([]);
let status = {};

const searchQuery = ref('');
const sortField = ref('id');
const sortDirection = ref('asc');
let currentPage = ref(1);
const pageSize = ref(10);


const per_page = () => {
    saveToLocalStorage();
    fetchInvoices()

}
const onTypeKey = () => {
    fetchInvoices();
};
const onClickLinks = (link) => {
    if (!link) return;
    fetchInvoices(link)
}
const setPaginate = (paginate_data) => {
    paginate.value.prev_page_url = paginate_data.prev_page_url;
    paginate.value.next_page_url = paginate_data.next_page_url;
    paginate.value.links = paginate_data.links;
    paginate.value.from = paginate_data.from;
    paginate.value.to = paginate_data.to;
    paginate.value.total = paginate_data.total;
    paginate.value.currentPage = paginate_data.currentPage;
}

let fetchInvoices = async (url = '/invoice/search') => {
    // loading.value = true
    try {
        const { data } = await axios.get(url, {
            params: {
                search: searchQuery.value,
                paginate: pageSize.value,
            }
        });
        console.log(data)
        let invoice = data.invoices;
        invoices.value = invoice.data;
        status=data.status;
        setPaginate(invoice);

    } catch (e) {
        console.error(e)
    } finally {
        // loading.value = false
    }
}

onMounted(() => {
    getFromLocalStorage();
    fetchInvoices();
});

const filteredInvoices = computed(() => {

    let filtered = invoices.value;
    filtered.sort((a, b) => {
        let aVal = a[sortField.value];
        let bVal = b[sortField.value];

        if (typeof aVal === 'string') {
            aVal = aVal.toLowerCase();
            bVal = bVal.toLowerCase();
        }

        if (aVal < bVal) return sortDirection.value === 'asc' ? -1 : 1;
        if (aVal > bVal) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });

 return filtered;
});

const totalInvoices = computed(() => paginate.value.total);

// const totalPages = computed(() => Math.ceil(invoices.value.length / pageSize.value));
const totalPages = computed(() => paginate.value.links ? paginate.value.links.length : 0);

// const statusCounts = computed(() => {
//     const counts = { paid: 0, pending: 0, overdue: 0, partial: 0 };
//     invoices.value.forEach(invoice => {
//         counts[invoice.status]++;
//     });
//     return counts;
// });

// Methods
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
};

const getStatusClass = (status) => {
    const classes = {
        'paid': 'bg-green-100 text-green-800',
        'pending': 'bg-yellow-100 text-yellow-800',
        'overdue': 'bg-red-100 text-red-800',
        'partial': 'bg-blue-100 text-blue-800'
    };
    return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusIcon = (status) => {
    const icons = {
        'paid': 'fas fa-check-circle',
        'pending': 'fas fa-clock',
        'overdue': 'fas fa-exclamation-circle',
        'partial': 'fas fa-hourglass-half'
    };
    return icons[status] || 'fas fa-question-circle';
};

const sortBy = (field) => {
    if (sortField.value === field) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }
};

const sortIcon = (field) => {
    if (sortField.value !== field) return 'text-gray-300';
    return sortDirection.value === 'asc' ? 'fa-sort-up' : 'fa-sort-down';
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const saveToLocalStorage = () => {
    localStorage.setItem('pageSize', pageSize.value);
};
const getFromLocalStorage = () => {
    let page = localStorage.getItem('pageSize');
    if (page) {
        pageSize.value = page;
    }
};

// const addInvoice = () => {
//     const newId = Math.max(...invoices.value.map(i => i.id), 0) + 1;
//     const invoice = {
//         id: newId,
//         invoiceId: `INV-${String(newId).padStart(3, '0')}`,
//         customerName: newInvoice.value.customerName,
//         createdAt: new Date().toISOString().split('T')[0],
//         totalAmount: parseFloat(newInvoice.value.totalAmount),
//         paidAmount: parseFloat(newInvoice.value.paidAmount),
//         status: newInvoice.value.status
//     };

//     invoices.value.push(invoice);
//     saveToLocalStorage();
//     resetNewInvoice();
//     showAddForm.value = false;
// };


const view = (id) => {
    return `${id}/preview`
   // alert(`Viewing invoice: ${invoice.invoice_number}\nCustomer: ${invoice.customer.name}\nTotal: ${formatCurrency(invoice.total_amount)}`);
};

const editInvoice = (invoice) => {
    alert(`Editing invoice: ${invoice.invoice_number}`);
    // In a real app, you'd open an edit form with the invoice data
};

const downloadInvoice = (invoice) => {
    alert(`Downloading invoice: ${invoice.invoice_number}`);
    // In a real app, you'd generate and download a PDF
};

const deleteInvoice = (id) => {
    if (confirm('Are you sure you want to delete this invoice?')) {
        invoices.value = invoices.value.filter(invoice => invoice.id !== id);
        saveToLocalStorage();
    }
};

</script>
