<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management - Vue.js</title>

</head>
<body class="bg-gray-50 min-h-screen">
    <div id="app" class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Invoice Management</h1>
            <p class="text-gray-600 mt-2">Manage and track all your invoices</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                        <p class="text-2xl font-bold text-gray-900">{{ uu }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ statusCounts.paid }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ statusCounts.pending }}</p>
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
                        <p class="text-2xl font-bold text-gray-900">{{ statusCounts.overdue }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Invoice Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-8" v-if="showAddForm">
            <h3 class="text-lg font-semibold mb-4">Add New Invoice</h3>
            <form @submit.prevent="addInvoice" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
                    <input v-model="newInvoice.customerName" type="text" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                    <input v-model="newInvoice.totalAmount" type="number" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paid Amount</label>
                    <input v-model="newInvoice.paidAmount" type="number" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select v-model="newInvoice.status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                        <option value="partial">Partial</option>
                    </select>
                </div>
                <div class="md:col-span-2 lg:col-span-4 flex space-x-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Invoice
                    </button>
                    <button type="button" @click="cancelAdd"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Invoice List</h2>
                    <div class="mt-4 md:mt-0 flex space-x-3">
                        <div class="relative">
                            <input v-model="searchQuery" type="text" placeholder="Search invoices..."
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <button @click="showAddForm = true"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            New Invoice
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('id')">
                                #
                                <i class="fas fa-sort ml-1" :class="sortIcon('id')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('invoiceId')">
                                Invoice ID
                                <i class="fas fa-sort ml-1" :class="sortIcon('invoiceId')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('customerName')">
                                Customer Name
                                <i class="fas fa-sort ml-1" :class="sortIcon('customerName')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('createdAt')">
                                Created At
                                <i class="fas fa-sort ml-1" :class="sortIcon('createdAt')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('totalAmount')">
                                Total Amount
                                <i class="fas fa-sort ml-1" :class="sortIcon('totalAmount')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('paidAmount')">
                                Paid Amount
                                <i class="fas fa-sort ml-1" :class="sortIcon('paidAmount')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('status')">
                                Status
                                <i class="fas fa-sort ml-1" :class="sortIcon('status')"></i>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(invoice, index) in filteredInvoices" :key="invoice.id"
                            class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ (currentPage - 1) * pageSize + index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                {{ invoice.invoiceId }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ invoice.customerName }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ formatDate(invoice.createdAt) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ formatCurrency(invoice.totalAmount) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ formatCurrency(invoice.paidAmount) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusClass(invoice.status)}`">
                                    <i :class="`${getStatusIcon(invoice.status)} mr-1`"></i>
                                    {{ invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button @click="viewInvoice(invoice)"
                                            class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button @click="editInvoice(invoice)"
                                            class="text-green-600 hover:text-green-900 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button @click="downloadInvoice(invoice)"
                                            class="text-purple-600 hover:text-purple-900 transition-colors" title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button @click="deleteInvoice(invoice.id)"
                                            class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="filteredInvoices.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No invoices found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-sm text-gray-700 mb-4 md:mb-0">
                        Showing <span class="font-medium">{{ (currentPage - 1) * pageSize + 1 }}</span>
                        to <span class="font-medium">{{ Math.min(currentPage * pageSize, totalInvoices) }}</span>
                        of <span class="font-medium">{{ totalInvoices }}</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button @click="prevPage" :disabled="currentPage === 1"
                                :class="`px-3 py-1 border border-gray-300 rounded-md text-sm font-medium ${currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50'}`">
                            Previous
                        </button>
                        <button v-for="page in totalPages" :key="page"
                                @click="currentPage = page"
                                :class="`px-3 py-1 border rounded-md text-sm font-medium ${currentPage === page ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-300 text-gray-700 hover:bg-gray-50'}`">
                            {{ page }}
                        </button>
                        <button @click="nextPage" :disabled="currentPage === totalPages"
                                :class="`px-3 py-1 border border-gray-300 rounded-md text-sm font-medium ${currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-700 hover:bg-gray-50'}`">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const { createApp, ref, computed, onMounted } = Vue;

        createApp({
            setup() {
                // Reactive data
                const invoices = ref([]);
                const searchQuery = ref('');
                const sortField = ref('id');
                const sortDirection = ref('asc');
                const currentPage = ref(1);
                const pageSize = ref(10);
                const showAddForm = ref(false);
                const newInvoice = ref({
                    customerName: '',
                    totalAmount: 0,
                    paidAmount: 0,
                    status: 'pending'
                });

                // Initial dummy data
                const initialInvoices = [
                    {
                        id: 1,
                        invoiceId: "INV-001",
                        customerName: "John Smith",
                        createdAt: "2024-01-15",
                        totalAmount: 1250.00,
                        paidAmount: 1250.00,
                        status: "paid"
                    },
                    {
                        id: 2,
                        invoiceId: "INV-002",
                        customerName: "Sarah Johnson",
                        createdAt: "2024-01-16",
                        totalAmount: 890.50,
                        paidAmount: 0.00,
                        status: "pending"
                    },
                    {
                        id: 3,
                        invoiceId: "INV-003",
                        customerName: "Mike Wilson",
                        createdAt: "2024-01-10",
                        totalAmount: 2100.75,
                        paidAmount: 1500.00,
                        status: "partial"
                    },
                    {
                        id: 4,
                        invoiceId: "INV-004",
                        customerName: "Emily Davis",
                        createdAt: "2024-01-05",
                        totalAmount: 450.00,
                        paidAmount: 0.00,
                        status: "overdue"
                    }
                ];

                // Initialize data
                onMounted(() => {
                    const savedInvoices = localStorage.getItem('invoices');
                    if (savedInvoices) {
                        invoices.value = JSON.parse(savedInvoices);
                    } else {
                        invoices.value = initialInvoices;
                        saveToLocalStorage();
                    }
                });

                // Computed properties
                const filteredInvoices = computed(() => {
                    let filtered = invoices.value.filter(invoice =>
                        invoice.customerName.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                        invoice.invoiceId.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                        invoice.status.toLowerCase().includes(searchQuery.value.toLowerCase())
                    );

                    // Sorting
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

                    // Pagination
                    const start = (currentPage.value - 1) * pageSize.value;
                    const end = start + pageSize.value;
                    return filtered.slice(start, end);
                });

                const totalInvoices = computed(() => invoices.value.length);
                const totalPages = computed(() => Math.ceil(invoices.value.length / pageSize.value));

                const statusCounts = computed(() => {
                    const counts = { paid: 0, pending: 0, overdue: 0, partial: 0 };
                    invoices.value.forEach(invoice => {
                        counts[invoice.status]++;
                    });
                    return counts;
                });

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
                    localStorage.setItem('invoices', JSON.stringify(invoices.value));
                };

                const addInvoice = () => {
                    const newId = Math.max(...invoices.value.map(i => i.id), 0) + 1;
                    const invoice = {
                        id: newId,
                        invoiceId: `INV-${String(newId).padStart(3, '0')}`,
                        customerName: newInvoice.value.customerName,
                        createdAt: new Date().toISOString().split('T')[0],
                        totalAmount: parseFloat(newInvoice.value.totalAmount),
                        paidAmount: parseFloat(newInvoice.value.paidAmount),
                        status: newInvoice.value.status
                    };

                    invoices.value.push(invoice);
                    saveToLocalStorage();
                    resetNewInvoice();
                    showAddForm.value = false;
                };

                const resetNewInvoice = () => {
                    newInvoice.value = {
                        customerName: '',
                        totalAmount: 0,
                        paidAmount: 0,
                        status: 'pending'
                    };
                };

                const cancelAdd = () => {
                    resetNewInvoice();
                    showAddForm.value = false;
                };

                const viewInvoice = (invoice) => {
                    alert(`Viewing invoice: ${invoice.invoiceId}\nCustomer: ${invoice.customerName}\nTotal: ${formatCurrency(invoice.totalAmount)}`);
                };

                const editInvoice = (invoice) => {
                    alert(`Editing invoice: ${invoice.invoiceId}`);
                    // In a real app, you'd open an edit form with the invoice data
                };

                const downloadInvoice = (invoice) => {
                    alert(`Downloading invoice: ${invoice.invoiceId}`);
                    // In a real app, you'd generate and download a PDF
                };

                const deleteInvoice = (id) => {
                    if (confirm('Are you sure you want to delete this invoice?')) {
                        invoices.value = invoices.value.filter(invoice => invoice.id !== id);
                        saveToLocalStorage();
                    }
                };

                return {
                    invoices,
                    searchQuery,
                    sortField,
                    sortDirection,
                    currentPage,
                    pageSize,
                    showAddForm,
                    newInvoice,
                    filteredInvoices,
                    totalInvoices,
                    totalPages,
                    statusCounts,
                    formatCurrency,
                    formatDate,
                    getStatusClass,
                    getStatusIcon,
                    sortBy,
                    sortIcon,
                    nextPage,
                    prevPage,
                    addInvoice,
                    cancelAdd,
                    viewInvoice,
                    editInvoice,
                    downloadInvoice,
                    deleteInvoice
                };
            }
        }).mount('#app');
    </script>
</body>
</html>
