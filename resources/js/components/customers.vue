<template>
    <div id="invoice" class="container mx-auto px-4 py-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-file-invoice text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Client</p>
                        <p class="text-xl font-bold text-gray-900">{{ status.total }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">New Client</p>
                        <p class="text-xl font-bold text-gray-900">{{ status.new }}</p>
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
                        <p class="text-xl font-bold text-gray-900">{{ status.unpaid }}</p>
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
                        <p class="text-xl font-bold text-gray-900">{{ status.overdue }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <!-- <h2 class="text-xl font-semibold text-gray-800">Invoice List</h2> -->
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
                                placeholder="Search clients..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>

                        </div>
                        <a href="/dashboard/customers/add" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            New Client
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>

                            <th class="px-3 py-2 w-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer text-inline"
                                @click="sortBy('id')">#
                                <i class="fas fa-sort ml-1" :class="sortIcon('id')"></i>
                            </th>
                            <th class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('name')">
                                Name
                                <i class="fas fa-sort ml-1" :class="sortIcon('name')"></i>
                            </th>
                            <th class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('email')">
                                email
                                <i class="fas fa-sort ml-1" :class="sortIcon('email')"></i>
                            </th>
                            <th class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('phone')">
                                Phone
                                <i class="fas fa-sort ml-1" :class="sortIcon('phone')"></i>
                            </th>
                            <th class="px-1 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                                @click="sortBy('address')">
                                Address
                                <i class="fas fa-sort ml-1" :class="sortIcon('address')"></i>
                            </th>

                            <th
                                class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(customer, index) in filteredData" :key="customer.id"
                            class="hover:bg-gray-50 transition-colors duration-150">

                            <td class="px-0.5 py-2 whitespace-nowrap text-sm font-medium text-blue-600 text-center">
                                {{ customer.id }}
                            </td>
                            <td class="px-0.5 py-2 whitespace-nowrap text-sm text-gray-900">
                                {{ customer.name }}
                            </td>
                            <td class="px-0.5 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ customer.email }}
                            </td>
                            <td class="px-0.5 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ customer.phone }}
                            </td>
                            <td class="px-0.5 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ customer.address }}
                            </td>

                            <td class="px-2 py-2 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a :href="view(customer.id)"
                                        class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                </a>
                                    <a :href="edit(customer.id)"
                                        class="text-green-600 hover:text-green-900 transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                            </a>
                                    <button @click="downloadInvoice(customer)"
                                        class="text-purple-600 hover:text-purple-900 transition-colors"
                                        title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button @click="confirmDelete(customer.id)"
                                        class="text-red-600 hover:text-red-900 transition-colors" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="collection.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No Client found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
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

let collection = ref([]);
let paginate = ref([]);
let status = {};

const searchQuery = ref('');
const sortField = ref('id');
const sortDirection = ref('asc');
const pageSize = ref(10);
// let links;

const per_page = () => {
    saveToLocalStorage();
    fetchCustomers();

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
const onTypeKey = () => {
    fetchCustomers();
};
const onClickLinks = (link) => {
    if (!link) return;
    fetchCustomers(link)
}

let fetchCustomers = async (url = '/dashboard/customers/search') => {
    // loading.value = true
    try {
        const { data } = await axios.get(url, {
            params: {
                search: searchQuery.value,
                paginate: pageSize.value,
            }
        });
        // console.log(data)
        const customers = data.customers;
        collection.value = customers.data;
        status = data.status;
        setPaginate(customers);

    } catch (e) {
        console.error(e)
    } finally {
        // loading.value = false
        // console.log('final resp')
    }
}

onMounted(() => {
    getFromLocalStorage();
    fetchCustomers();
});

const filteredData = computed(() => {
    let filtered = collection.value;
    filtered.sort((a, b) => {
        let aVal = a[sortField.value];
        let bVal = b[sortField.value];

        if (typeof aVal === 'string') {
            aVal = aVal.toLowerCase();
            bVal = bVal
                .toLowerCase();
        }
        if (aVal < bVal) return sortDirection.value === 'asc' ? -1 : 1;
        if (aVal > bVal) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });

    return filtered;
});


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


const saveToLocalStorage = () => {
    localStorage.setItem('pageSize', pageSize.value);
};
const getFromLocalStorage = () => {
    let page = localStorage.getItem('pageSize');
    if (page) {
        pageSize.value = page;
    }
};

const viewInvoice = (item) => {
    alert(`Viewing invoice: ${item.id}\nCustomer: ${item.name}\nTotal: ${item.email} `);
};

const editInvoice = (item) => {
    alert(`Editing invoice: ${item.id}`);
};

const downloadInvoice = (item) => {
    alert(`Downloading invoice: ${item.id}`);
};

const deleteInvoice = (item) => {
    if (confirm('Are you sure you want to delete this invoice?')) {
        alert(item.id)
    }
};
// 🔹 Action buttons
const view = (id) => `customers/${id}/view`
const edit = (id) => `customers/${id}/update`
const confirmDelete = async (id) => {
    if (confirm('Are you sure to delete this customer?')) {
        await axios.post(`/customers/${id}/delete`)
        fetchCustomers()
    }
}

</script>
