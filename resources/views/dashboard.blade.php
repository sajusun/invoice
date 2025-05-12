<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false, isLoggedIn: true }" class="h-full">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invozen Dashboard - Manage Your Invoices</title>
    <meta name="description"
          content="Access your Invozen dashboard to track invoices, manage clients, and monitor payments with ease.">
    <meta name="keywords" content="invoice dashboard, manage invoices, invoice tracker">
    <meta name="robots" content="noindex, follow"> <!-- Prevents indexing but allows following links -->
    <link rel="canonical" href="{{config('app.live_url')}}/dashboard">
</head>
<body class="bg-gray-100 h-full">
{{--navbar--}}
@include('custom-layouts.navbar')
<!-- Sidebar -->
<div class="flex">
    @include('custom-layouts.sidebar_dashboard')


<main class="flex-1 p-6">
    @if (session('welcome_message'))
        <nav id="welcome_message" class="navbar navbar-light bg-light p-3 mb-4 transition-opacity duration-500">
        <span>
            {{ session('welcome_message') }} <strong>{{ Auth::user()->name }}</strong>
        </span>
        </nav>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Total Invoices -->
        <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
            <h3 class="text-gray-500 text-sm">Total Invoices</h3>
            <p class="text-2xl font-bold text-blue-600 mt-2">{{$num_of_invoices}}</p>
        </div>

        <!-- Pending Invoices -->
        <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
            <h3 class="text-gray-500 text-sm">Pending Invoices</h3>
            <p class="text-2xl font-bold text-yellow-500 mt-2">{{$status}}</p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
            <h3 class="text-gray-500 text-sm">Total Revenue</h3>
            <p class="text-2xl font-bold text-green-600 mt-2">{{$total}}</p>
        </div>
    </div>
    <div id="app" class="mt-4 list-view">
        <div class="flex py-1">
            <h4 class="w-2/5">Invoice List </h4>
            <span class="flex w-3/5 mr-1">
                <input v-model="search" @input="key_Searching" @keydown.enter="onTabSearch"
                       type="text"
                       id="searchInput"
                       placeholder="Search invoices..."
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
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="(invoice, index) in invoices" :key="invoice.id">
                <tr :href="invoice.invoice_number" class="list" onclick="toggleDetails(this)">
                    <td class="w-4">@{{++index}}</td>
                    <td class="left-1">@{{invoice.invoice_number}}</td>
                    <td>@{{invoice.customer.name}}</td>
                    <td>@{{invoice.total_amount}}</td>
                    <td>
                        <span v-if="invoice.status==='Pending'" class="bg-yellow-500 px-3 py-1 text-white rounded">@{{invoice.status}}</span>
                        <span v-else class="bg-green-500 px-3 py-1 text-white rounded">@{{invoice.status}}</span>
                    </td>
                </tr>

                <tr class="details-row hidden bg-gray-50">
                    <td colspan="6" class="px-3 py-2">
                        <div class="flex justify-around">
                            <div class="text-sm align-content-start text-left">
                                <div><b>Name:</b> @{{invoice.customer.name}}</div>
                                <div><b>Phone:</b> @{{invoice.customer.phone}}</div>
                                <div><b>Email:</b> @{{invoice.customer.email}}</div>

                            </div>
                            <div class="text-sm align-content-start text-left">
                                <div><b>Address:</b> @{{invoice.customer.address}}</div>
                                <div><b>Date:</b> @{{invoice.invoice_date}}</div>
                                <div><strong>Due:</strong> @{{invoice.total_amount - invoice.paid_amount}}</div>
                            </div>
                            <div class="flex items-center">
                                <a :href="goto(invoice.invoice_number)"
                                   class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                    <i class="fa fa-eye"></i> View</a>

                                <a href="#" class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">
                                    <i class="fa fa-edit"></i> Edit</a>

                                <button class="bg-red-500 text-white px-3 py-1 rounded text-xs"
                                        @click="confirmDelete(invoice.invoice_number)">
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
            <button @click="fetchInvoices(pagination.prev_page_url)" :disabled="!pagination.prev_page_url" class="px-4 py-2 bg-gray-300 rounded">Prev</button>
            <button @click="fetchInvoices(pagination.next_page_url)" :disabled="!pagination.next_page_url" class="px-4 py-2 bg-gray-300 rounded">Next</button>
        </div>
    </div>

</main>
</div>
@include('custom-layouts.footer')

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
        // remove active class previous selected roe
        document.querySelectorAll(".list").forEach(el => el.classList.remove("active"));

        row.classList.toggle("active");

        const nextRow = row.nextElementSibling;
        if (nextRow  && nextRow.classList.contains("details-row")) {

            // Toggle only the one after the clicked row
            nextRow.classList.toggle("hidden");


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

    // document.getElementById("searchInput").addEventListener('keyup', function (e) {
    //     const rows = document.querySelectorAll("table tbody tr");
    //     serverRequest.url = `${window.host}/invoice/search?search=${this.value}`;
    //     serverRequest.xGet().then((response) => {
    //         console.log(response)
    //     })
    //     rows.forEach((row) => {
    //         const text = row.textContent.toLowerCase();
    //         if (text.includes(this.value)) {
    //             row.classList.remove("hidden");
    //         } else {
    //             row.classList.add("hidden");
    //         }
    //     });
    // });


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

