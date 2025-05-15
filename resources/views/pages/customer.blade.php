<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false, isLoggedIn: true }" class="h-full">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invozen Dashboard - Manage Your Invoices</title>
    <meta name="description"
          content="Access your Invozen dashboard to track invoices, manage clients, and monitor payments with ease.">
    <meta name="keywords" content="invoice dashboard, manage invoices, invoice tracker">
    <meta name="robots" content="noindex, follow"> <!-- Prevents indexing but allows following links -->
    <link rel="canonical" href="{{config('app.live_url')}}/dashboard/customers">
</head>
<body class="bg-gray-100 h-full">
{{--navbar--}}
@include('custom-layouts.navbar')
<!-- Sidebar -->
<div class="flex">
    @include('custom-layouts.sidebar_dashboard')

    <main class="flex-1 p-6">
        <div id="customer">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Total Invoices -->
                <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
                    <h3 class="text-gray-500 text-sm">Total Invoices</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2">@{{ sum_of_invoices }}</p>
                </div>

                <!-- Pending Invoices -->
                <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
                    <h3 class="text-gray-500 text-sm">Pending Invoices</h3>
                    <p class="text-2xl font-bold text-yellow-500 mt-2">@{{status}}</p>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
                    <h3 class="text-gray-500 text-sm">Total Revenue</h3>
                    <p class="text-2xl font-bold text-green-600 mt-2">@{{total}}</p>
                </div>
            </div>
            <div class="mt-4 list-view">
                <div class="flex py-1">
                    <h4 class="w-2/5">Customers List </h4>
                    <span class="flex w-3/5 mr-1">
                <input v-model="search" @input="key_Searching()" @keydown.enter="onTabSearch"
                       type="text"
                       id="searchInput"
                       placeholder="Search Client..."
                       class="w-4/5 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring"
                />
                <button :disabled="search.trim()===''"
                        class="w-1/5 text-white bg-gray-400 border mx-0.5 rounded shadow-sm" @click="onTabSearch">@{{ searchBtn }}</button>
            </span>

                </div>
                <div v-if="loading" class="flex justify-center items-center h-32">
                    <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-500"></div>
                </div>
                <table v-else class="table" id="recentInvoice">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        {{--                <th>&nbsp;</th>--}}
                    </tr>
                    </thead>

                    <tbody>
                    <template v-for="(customer, index) in customers" :key="customer.id">
                        <tr class="list" onclick="toggleDetails(this)">
                            <td class="w-4">@{{++index}}</td>
                            <td class="left-1">@{{customer.id}}</td>
                            <td>@{{customer.name}}</td>
                            <td>@{{customer.phone}}</td>
                            <td>@{{customer.email}}</td>
                        </tr>

                        <tr class="details-row hidden bg-gray-50">
                            <td colspan="6" class="px-3 py-2">
                                <div class="flex justify-around">
                                    <div class="text-sm align-content-start text-left">
                                        <div><b>Name:</b> @{{customer.name}}</div>
                                        <div><b>Phone:</b> @{{customer.phone}}</div>
                                        <div><b>Email:</b> @{{customer.email}}</div>

                                    </div>
                                    <div class="text-sm align-content-start text-left">
                                        <div><b>Address:</b> @{{customer.address}}</div>
                                        <div><b>Date:</b> @{{customer.created_at}}</div>
                                        {{--                                <div><strong>Due:</strong> @{{invoice.total_amount - invoice.paid_amount}}</div>--}}
                                    </div>
                                    <div class="flex items-center">
                                        <a :href="goto(customer.id)"
                                           class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                            <i class="fa fa-eye"></i> View</a>

                                        <a href="#" class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">
                                            <i class="fa fa-edit"></i> Edit</a>

                                        <button class="bg-red-500 text-white px-3 py-1 rounded text-xs"
                                                @click="confirmDelete(customer.id)">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                {{--        <div class="mt-4">--}}
                {{--            {{ $invoices->links() }}--}}
                {{--        </div>--}}
                <!-- Pagination Controls -->
                <div class="flex gap-2 mt-4">
                    <button @click="fetchCustomers(pagination.prev_page_url)"
                            :disabled="!pagination.prev_page_url" class="px-4 py-2 bg-gray-300 rounded">Prev
                    </button>

                    <button @click="fetchCustomers(pagination.next_page_url)"
                            :disabled="!pagination.next_page_url" class="px-4 py-2 bg-gray-300 rounded">Next
                    </button>
                </div>
            </div>

        </div>
    </main>
</div>
@include('custom-layouts.footer')
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
<script>

    document.querySelectorAll(".list").forEach(item => {
        item.addEventListener("click", function () {
            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));
            this.querySelectorAll("td").forEach(th => th.classList.add("active"));
        });
    });

    function toggleDetails(row) {
        // Hide all other detail rows first
        document.querySelectorAll(".details-row").forEach(r => r.classList.add("hidden"));
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains("details-row")) {
            // Toggle only the one after the clicked row
            nextRow.classList.toggle("hidden");
        }
    }
</script>
<script>
    const {createApp} = Vue;

    createApp({
        data() {
            return {
                customers: [],
                pagination: {},
                search: '',
                sum_of_invoices: '',
                status: '',
                total: '',
                loading: false,
                searchBtn: "Search",
                ready: false,
                url: `${host}/dashboard/customers/search?search=`
            }
        },
        mounted() {
            this.fetchCustomers(this.url);
        },
        methods: {
            fetchCustomers(url) {
                this.searchBtn = "searching";
                this.loading = true;
                axios.get(`${url}${this.search}`)
                    .then(response => {
                        this.searchBtn = "Search";

                        console.log(response.data)
                        this.customers = response.data['customers'].data;
                        this.status = response.data['status'];
                        this.sum_of_invoices = response.data['sum_of_invoices'];
                        this.total = response.data['total'];

                        let data = response.data['customers'];
                        this.loading = false;
                        this.searchBtn = "Search";
                        this.pagination = {
                            current_page: data.current_page,
                            last_page: data.last_page,
                            next_page_url: data.next_page_url,
                            prev_page_url: data.prev_page_url
                        };

                    });
            },
            key_Searching() {
                if (this.search.trim() === '' && this.ready) {
                    this.ready = false;
                    this.fetchCustomers(this.url);
                }

            },
            onTabSearch() {
                if (this.search.trim() === '') {
                    return
                }
                this.fetchCustomers(this.url);
                this.ready = true;
            },
            goto(customer_id) {
                return `${host}/dashboard/customers/${customer_id}/preview`
            },
            confirmDelete(uid) {
                let url = `${host}/customer/${uid}/delete`
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will permanently delete the Client.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Create and submit a form dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;

                        const token = document.createElement('input');
                        token.type = 'text';
                        token.name = '_token';
                        token.value = '{{ csrf_token() }}';
                        form.appendChild(token);

                        const method = document.createElement('input');
                        method.type = 'text';
                        method.name = '_method';
                        method.value = 'POST';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        },

    }).mount('#customer');

</script>

@if (session('response'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: '{{session('response')}}',
            title: '{{ session("message") }}',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: false,
        });
    </script>
@endif


