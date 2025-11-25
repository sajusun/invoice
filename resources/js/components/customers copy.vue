<template>
    <div id="customer" class="w-full xl:max-w-5xl py-1 px-1 xl:pl-10">
        <div class="mt-4 list-view">

            <div class="flex py-1">
                <span class="flex w-4/5 md:w-3/5 mr-1 text-xs sm:text-sm md:text-base h-8 md:h-10">
          <input v-model="search"
                 @input="key_Searching"
                 @keydown.enter="onTabSearch"
                 type="text"
                 id="searchInput"
                 placeholder="Search Client..."
                 class="w-4/5 px-4 py-2 border rounded shadow-sm focus:outline-none focus-visible:ring-0"
          />
          <button :disabled="search.trim()===''"
                  class="w-1/5 text-white bg-gray-400 border mx-0.5 rounded shadow-sm"
                  @click="onTabSearch">
            {{ searchBtn }}
          </button>
        </span>
            </div>
            <div v-if="isEmpty" class="text-center text-gray-500 text-lg py-4">
                No Data Found!
            </div>
            <div v-else>
                <div v-if="loading" class="flex justify-center items-center h-32">
                    <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-500"></div>
                </div>

                <table v-else class="min-w-full divide-y divide-gray-200 text-xs md:text-sm lg:text-md">
                    <thead>
                    <tr>
                        <th class="p-1.5">#</th>
                        <th>Client Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-400 text-sm text-gray-800">
                    <tr v-for="(customer, index) in customers" :key="customer.id"
                        class="list hover:bg-gray-50 text-center cursor-pointer"
                        @click="toggleDetails(index)">
                        <td class="w-4 p-1.5">{{ index + 1 }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.email }}</td>
                    </tr>

                    <tr v-if="openDetails === index"
                        class="details-row bg-gray-50">
                        <td colspan="6" class="px-3 py-2">
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="col-span-1 lg:col-span-1 text-xs sm:text-sm text-left">
                                    <div><b>Name:</b> {{ customer.name }}
                                        <i class="fa fa-angle-right"></i>
                                        <span class="font-semibold">UID : {{ customer.id }}</span>
                                    </div>
                                    <div><b>Phone:</b> {{ customer.phone }}</div>
                                    <div><b>Email:</b> {{ customer.email }}</div>
                                </div>

                                <div class="col-span-1 lg:col-span-1 text-xs sm:text-sm text-left">
                                    <div><b>Address:</b> {{ customer.address }}</div>
                                    <div><b>Date:</b> {{ customer.created_at }}</div>
                                </div>

                                <div class="col-span-2 lg:col-span-1 justify-center items-center">
                                    <a :href="goto(customer.id)"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a :href="goto_edit(customer.id)"
                                       class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <button class="bg-red-500 text-white px-3 py-1 rounded text-xs"
                                            @click="confirmDelete(customer.id)">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>


                <div class="flex gap-2 mt-4">
                    <button @click="fetchCustomers(pagination.prev_page_url)"
                            :disabled="!pagination.prev_page_url"
                            class="px-4 py-2 bg-gray-300 rounded">Prev</button>
                    <button @click="fetchCustomers(pagination.next_page_url)"
                            :disabled="!pagination.next_page_url"
                            class="px-4 py-2 bg-gray-300 rounded">Next</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const customers = ref([])
const search = ref('')
const searchBtn = ref('Search')
const isEmpty = ref(false)
const loading = ref(false)
const pagination = ref({})
const sum_of_invoices = ref(0)
const openDetails = ref(null)

// 🔹 Fetch customers from Laravel API
const fetchCustomers = async (url = '/dashboard/customers/search?search=') => {
    loading.value = true

    try {
        const { data } = await axios.get(url, {
            params: { search: search.value }

        })
        console.log(data.customers.data)
        customers.value = data.customers.data
        pagination.value = {
            prev_page_url: data.prev_page_url,
            next_page_url: data.next_page_url
        }
        sum_of_invoices.value = data.total
        isEmpty.value = customers.value.length === 0
    } catch (e) {
        console.error(e)
        customers.value = []
        isEmpty.value = true
    } finally {
        loading.value = false
    }
}

// 🔹 Searching
const key_Searching = () => {
    if (search.value.trim() === '') return
    fetchCustomers()
}
const onTabSearch = () => {
    fetchCustomers()
}

// 🔹 Toggle Details
const toggleDetails = (index) => {
    openDetails.value = openDetails.value === index ? null : index
}

// 🔹 Action buttons
const goto = (id) => `/customers/${id}`
const goto_edit = (id) => `/customers/${id}/edit`
const confirmDelete = async (id) => {
    if (confirm('Are you sure to delete this customer?')) {
        await axios.delete(`/api/customers/${id}`)
        fetchCustomers()
    }
}

// 🔹 Auto fetch on load
onMounted(() => {
    fetchCustomers()
})
</script>
