{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    @include('custom-layouts.headTagContent')--}}
{{--    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>--}}
{{--    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>--}}
{{--    <title>Customers</title>--}}
{{--    <style>--}}
{{--        .main-box.no-header {--}}
{{--            padding-top: 20px;--}}
{{--        }--}}

{{--        .main-box {--}}
{{--            background: #FFFFFF;--}}
{{--            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;--}}
{{--            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;--}}
{{--            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;--}}
{{--            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;--}}
{{--            box-shadow: 1px 1px 2px 0 #CCCCCC;--}}
{{--            margin-bottom: 16px;--}}
{{--            -webikt-border-radius: 3px;--}}
{{--            -moz-border-radius: 3px;--}}
{{--            border-radius: 3px;--}}
{{--        }--}}

{{--        .table a.table-link.danger {--}}
{{--            color: #e74c3c;--}}
{{--        }--}}

{{--        .label {--}}
{{--            border-radius: 3px;--}}
{{--            font-size: 0.875em;--}}
{{--            font-weight: 600;--}}
{{--        }--}}

{{--        .user-list tbody td .user-subhead {--}}
{{--            font-size: 0.875em;--}}
{{--            font-style: italic;--}}
{{--        }--}}

{{--        .user-list tbody td .user-link {--}}
{{--            display: block;--}}
{{--            font-size: 1.25em;--}}
{{--            padding-top: 3px;--}}
{{--            margin-left: 60px;--}}
{{--        }--}}

{{--        a {--}}
{{--            color: #3498db;--}}
{{--            outline: none !important;--}}
{{--        }--}}

{{--        .user-list tbody td > img {--}}
{{--            position: relative;--}}
{{--            max-width: 50px;--}}
{{--            float: left;--}}
{{--            margin-right: 15px;--}}
{{--        }--}}

{{--        .table thead tr th {--}}
{{--            text-transform: uppercase;--}}
{{--            font-size: 0.875em;--}}
{{--        }--}}

{{--        .table thead tr th {--}}
{{--            border-bottom: 2px solid #e7ebee;--}}
{{--        }--}}

{{--        .table tbody tr td:first-child {--}}
{{--            font-size: 1.125em;--}}
{{--            font-weight: 300;--}}
{{--        }--}}

{{--        .table tbody tr td {--}}
{{--            font-size: 0.875em;--}}
{{--            vertical-align: middle;--}}
{{--            border-top: 1px solid #e7ebee;--}}
{{--            padding: 12px 8px;--}}
{{--        }--}}

{{--        a:hover {--}}
{{--            text-decoration: none;--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--navbar--}}
{{--@include('custom-layouts.navbar')--}}
{{--left site bar--}}
{{--<div class="sidebar">--}}
{{--    @include('custom-layouts.sidebar_dashboard')--}}
{{--</div>--}}
{{--@php--}}
{{--    $sn=0;--}}
{{--@endphp--}}
{{--<div class="main-content">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="card p-3" onclick='find_invoices()'>--}}
{{--                <h5>Total Invoice</h5>--}}
{{--                <p id="invoice_Length">None</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="card p-3">--}}
{{--                <h5>Pending Payments</h5>--}}
{{--                <p id="pending">None</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-md-4">--}}
{{--            <div class="card p-3">--}}
{{--                <h5>Total Revenue</h5>--}}
{{--                <p id="revenue">None</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @include('custom-layouts.layout_customers')--}}

{{--    <div class="mt-4 list-view">--}}
{{--        <h4>Total Customers : {{$controller->total_customers()}}</h4>--}}

{{--        <table class="table user-list">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>#</th>--}}
{{--                <th>Name</th>--}}
{{--                <th>phone</th>--}}
{{--                <th>email</th>--}}
{{--                <th>&nbsp;</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($customers as $customer)--}}

{{--                <tr class="list" data-id="{{$customer->id}}">--}}
{{--                    <td>{{++$sn}}</td>--}}
{{--                    <td>{{$customer['name']}}</td>--}}
{{--                    <td>{{$customer['phone']}}</td>--}}
{{--                    <td>{{$customer['email']}}</td>--}}
{{--                    <td style="width: 10%;">--}}
{{--                        <a href="#" class="table-link text-info">--}}
{{--                                            <span class="fa-stack">--}}
{{--                                                <i class="fa fa-square fa-stack-2x"></i>--}}
{{--                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>--}}
{{--                                            </span>--}}
{{--                        </a>--}}
{{--                        <a href="#" class="table-link danger">--}}
{{--                                            <span class="fa-stack">--}}
{{--                                                <i class="fa fa-square fa-stack-2x"></i>--}}
{{--                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>--}}
{{--                                            </span>--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        <div id="app">--}}
{{--        <div class="flex py-1">--}}
{{--            <h4 class="w-2/5">Recent Invoices </h4>--}}
{{--            <span class="flex w-3/5 mr-1">--}}
{{--                <input v-model="search" @input="fetchInvoices"--}}
{{--                    type="text"--}}
{{--                    id="searchInput"--}}
{{--                    placeholder="Search invoices..."--}}
{{--                    class="w-4/5 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring"--}}
{{--                />--}}
{{--                <button class="w-1/5 text-white bg-gray-400 border mx-0.5 rounded shadow-sm">Search</button>--}}
{{--            </span>--}}

{{--        </div>--}}
{{--            <div class="p-4">--}}
{{--                <table class="min-w-full border border-gray-300 divide-y divide-gray-200">--}}
{{--                    <thead class="bg-gray-100">--}}
{{--                    <tr>--}}
{{--                        <th class="text-left px-4 py-2">Invoice No</th>--}}
{{--                        <th class="text-left px-4 py-2">Date</th>--}}
{{--                        <th class="text-left px-4 py-2">Total</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    <tr v-for="invoice in invoices" :key="invoice.id" class="hover:bg-gray-50">--}}
{{--                        <td class="px-4 py-2">@{{ invoice.name }}</td>--}}
{{--                        <td class="px-4 py-2">@{{ invoice.email }}</td>--}}
{{--                        <td class="px-4 py-2">@{{ invoice.phone }}</td>--}}
{{--                    </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"--}}
{{--        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"--}}
{{--        crossorigin="anonymous"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>--}}
{{--</html>--}}
{{--<script>--}}
{{--    function set_invoices(data) {--}}
{{--        document.getElementById('invoice_Length').innerText = data;--}}
{{--    }--}}

{{--    function set_pending(data) {--}}
{{--        document.getElementById('pending').innerText = data;--}}
{{--    }--}}

{{--    function set_revenue(data) {--}}
{{--        document.getElementById('revenue').innerText = data;--}}
{{--    }--}}

{{--    let customerId;--}}
{{--    serverRequest = new serverRequest();--}}
{{--    // Select all elements with class "customer-item"--}}
{{--    document.querySelectorAll(".list").forEach(item => {--}}
{{--        item.addEventListener("click", function () {--}}
{{--            customerId = this.getAttribute("data-id");--}}
{{--            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));--}}
{{--            this.querySelectorAll("td").forEach(th => th.classList.add("active"));--}}

{{--            console.log(customerId)--}}
{{--            serverRequest.url = `http://localhost:8000/dashboard/customers/${customerId}`;--}}
{{--            serverRequest.xGet().then((response) => {--}}
{{--                let object = response['customer_data'];--}}
{{--                set_invoices(object.invoices.length)--}}
{{--                set_pending(response['customer_pending'])--}}
{{--                set_revenue(response['customer_revenue'])--}}
{{--            })--}}
{{--        });--}}
{{--    });--}}

{{--    function find_invoices() {--}}

{{--        serverRequest.url = `http://localhost:8000/dashboard/customers/${customerId}/invoice`;--}}
{{--        serverRequest.xGet().then((response) => {--}}
{{--            console.log(response)--}}
{{--        })--}}

{{--    }--}}
{{--</script>--}}
{{--<script>--}}
{{--    const { createApp } = Vue;--}}

{{--    createApp({--}}
{{--        data() {--}}
{{--            return {--}}
{{--                invoices: @json($customers),--}}
{{--                search: ''--}}
{{--            }--}}
{{--        },--}}
{{--        mounted() {--}}
{{--           // this.fetchInvoices();--}}
{{--        },--}}
{{--        methods: {--}}
{{--            fetchInvoices() {--}}
{{--                axios.get(`http://localhost:8000/invoice/search?search=${this.search}`)--}}
{{--                    .then(response => {--}}
{{--                        console.log(response.data['invoices'].data)--}}
{{--                        this.invoices = response.data['invoices'].data;--}}
{{--                    });--}}
{{--            }--}}
{{--        },--}}

{{--    }).mount('#app');--}}
{{--</script>--}}



    <!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <title>Invozen Dashboard - Manage Your Invoices</title>
    <meta name="description"
          content="Access your Invozen dashboard to track invoices, manage clients, and monitor payments with ease.">
    <meta name="keywords" content="invoice dashboard, manage invoices, invoice tracker">
    <meta name="robots" content="noindex, follow"> <!-- Prevents indexing but allows following links -->
    <link rel="canonical" href="{{config('app.live_url')}}/dashboard/customers">
    <style>

        .fade-out {
            opacity: 0;
        }
    </style>
</head>
<body>
{{--navbar--}}
@include('custom-layouts.navbar')
{{--left site bar--}}
<div class="sidebar">
    @include('custom-layouts.sidebar_dashboard')
</div>

<div class="main-content" id="app">

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
    <div  class="mt-4 list-view">
        <div class="flex py-1">
            <h4 class="w-2/5">Customers List </h4>
            <span class="flex w-3/5 mr-1">
                <input v-model="search" @input="key_Searching" @keydown.enter="onTabSearch"
                       type="text"
                       id="searchInput"
                       placeholder="Search invoices..."
                       class="w-4/5 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring"
                />
                <button :disabled="search.trim()===''" class="w-1/5 text-white bg-gray-400 border mx-0.5 rounded shadow-sm" @click="onTabSearch">@{{ searchBtn }}</button>
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
                <tr :href="customer.id" class="list" :data-id="customer.id" onclick="toggleDetails(this)">
                    <td class="w-4">@{{++index}}</td>
                    <td class="left-1">@{{customer.id}}</td>
                    <td>@{{customer.name}}</td>
                    <td>@{{customer.phone}}</td>
                    <td>@{{customer.email}}</td>
                </tr>

                <tr class="details-row hide bg-gray-50">
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
                                <a :href="goto(customer.id)" class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                    <i class="fa fa-eye"></i> View</a>

                                <a href="#" class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">
                                    <i class="fa fa-edit"></i> Edit</a>

                                <button class="bg-red-500 text-white px-3 py-1 rounded text-xs" @click="confirmDelete(customer.id)" >
                                    <i class="fa fa-trash"></i> Delete</button>
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
            <button
                @click="fetchInvoices(pagination.prev_page_url)"
                :disabled="!pagination.prev_page_url"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                Prev
            </button>

            <button
                @click="fetchInvoices(pagination.next_page_url)"
                :disabled="!pagination.next_page_url"
                class="px-4 py-2 bg-gray-300 rounded"
            >
                Next
            </button>
        </div>
    </div>

</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
<script>
    function set_name(data) {
        document.getElementById('customerName').innerText = data;
    }

    function set_email(data) {
        document.getElementById('customerEmail').innerText = data;
    }

    function set_phone(data) {
        document.getElementById('customerPhone').innerText = data;
    }

    function set_address(data) {
        document.getElementById('customerAddress').innerText = data;
    }

    serverRequest = new serverRequest();
    document.querySelectorAll(".list").forEach(item => {
        item.addEventListener("click", function () {
            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));
            this.querySelectorAll("td").forEach(th => th.classList.add("active"));
        });
    });

    function toggleDetails(row) {
        // Hide all other detail rows first
        document.querySelectorAll(".details-row").forEach(r => r.classList.add("hide"));
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains("details-row")) {
            // Toggle only the one after the clicked row
            nextRow.classList.toggle("hide");
        }
    }

    // function filterInvoices() {
    //     const input = document.getElementById("searchInput").value.toLowerCase();
    //     const rows = document.querySelectorAll("table tbody tr");
    //     serverRequest.url = `http://localhost:8000/invoice/search?search=${input}`;
    //     serverRequest.xGet().then((response) => {
    //         console.log(response)
    //         // document.getElementById("customerCard").classList.remove("hidden");
    //     })
    //     rows.forEach((row) => {
    //         const text = row.textContent.toLowerCase();
    //         if (text.includes(input)) {
    //             row.classList.remove("hidden");
    //         } else {
    //             row.classList.add("hidden");
    //         }
    //     });
    // }
    document.getElementById("searchInput").addEventListener('keyup',function (e) {
        const rows = document.querySelectorAll("table tbody tr");
        serverRequest.url = `http://localhost:8000/invoice/search?search=${this.value}`;
        serverRequest.xGet().then((response) => {
            console.log(response)
        })
        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            if (text.includes(this.value)) {
                row.classList.remove("hidden");
            } else {
                row.classList.add("hidden");
            }
        });
    });


</script>
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                customers: [],
                pagination:{},
                search: '',
                sum_of_invoices:'',
                status:'',
                total:'',
                loading:false,
                searchBtn:"Search",
                ready:false,
                url:'http://localhost:8000/dashboard/customers/search?search='
            }
        },
        mounted() {
            this.fetchInvoices(this.url);
        },
        methods: {
            fetchInvoices(url) {
                this.searchBtn="searching";
                this.loading = true;
                axios.get(`${url}${this.search}`)
                    .then(response => {
                        this.searchBtn="Search";

                        console.log(response.data)
                        this.customers = response.data['customers'].data;
                        this.status = response.data['status'];
                        this.sum_of_invoices = response.data['sum_of_invoices'];
                        this.total = response.data['total'];

                        let data=response.data['customers'];
                        this.loading =false;
                        this.searchBtn="Search";
                        this.pagination = {
                            current_page: data.current_page,
                            last_page: data.last_page,
                            next_page_url: data.next_page_url,
                            prev_page_url: data.prev_page_url
                        };

                    });
            },
            key_Searching(){
                if(this.search.trim()==='' && this.ready){
                    this.ready=false;

                    this.fetchInvoices(this.url);
                }

            },
            onTabSearch(){
                if(this.search.trim()===''){
                    return
                }
                this.fetchInvoices(this.url);
                this.ready=true;

            },
            goto(invoice_number){
                return `${host}/invoice/${invoice_number}/preview`
            },
            confirmDelete(url) {
                url=`${host}/invoice/${url}/delete`
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will permanently delete the invoice.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit a form dynamically
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;

                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = '{{ csrf_token() }}';
                        form.appendChild(token);

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'POST';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

        },

    }).mount('#app');
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
@if(session('welcome_message'))
    <script>
        setTimeout(() => {
            const alertBox = document.getElementById("welcome_message");
            if (alertBox) {
                alertBox.classList.add("fade-out"); // apply fade-out style
                setTimeout(() => {
                    alertBox.remove(); // remove after transition
                }, 500); // matches the CSS duration (500ms)
            }
        }, 3000);// 3000 milliseconds = 3 seconds
    </script>
@endif

