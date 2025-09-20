{{--<!DOCTYPE html>--}}
{{--<html lang="en" x-data="{ sidebarOpen: false, isLoggedIn: true }" class="h-full">--}}
{{--<head>--}}
{{--    @vite('resources/js/customer.js')--}}
{{--    @include('custom-layouts.headTagContent')--}}
{{--    <title>Invozen Dashboard - Manage Your Invoices</title>--}}
{{--    <meta name="description"--}}
{{--          content="Access your Invozen dashboard to track invoices, manage clients, and monitor payments with ease.">--}}
{{--    <meta name="keywords" content="invoice dashboard, manage invoices, invoice tracker">--}}
{{--    <meta name="robots" content="noindex, follow"> <!-- Prevents indexing but allows following links -->--}}
{{--    <link rel="canonical" href="{{config('app.live_url')}}/dashboard/customers">--}}
{{--</head>--}}
{{--<body class="bg-gray-100 h-full">--}}
{{--navbar--}}
{{--@include('custom-layouts.navbar')--}}
{{--<!-- Sidebar -->--}}
{{--<div class="flex h-[calc(100vh-8rem)] md:h-[calc(100vh-10rem)]">--}}
{{--    @include('custom-layouts.sidebar_dashboard')--}}

{{--    <main class="flex-1 p-1.5 sm:p-2.5 md:p-4 md:pb-6">--}}
<x-dashboard-layout>
    <x-slot name="meta">
{{--        @vite('resources/js/customer.js')--}}
        <title>Invozen Dashboard - Manage Your Invoices</title>
    </x-slot>
    <div id="app">
        <customers></customers>
    </div>
{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
{{--        <div id="customer" class="w-full xl:max-w-5xl py-1 px-1  xl:pl-10">--}}
{{--            <div class="mt-4 list-view">--}}
{{--                <div class="flex py-1">--}}
{{--                    <h4 class="text-sm md:text-base font-semibold w-1/5 md:w-2/5 flex items-center">Customers List--}}
{{--                        @{{sum_of_invoices}}</h4>--}}
{{--                    <span class="flex w-4/5 md:w-3/5 mr-1 text-xs sm:text-sm md:text-base h-8 md:h-10">--}}
{{--                         <input v-model="search"--}}
{{--                                @input="key_Searching()"--}}
{{--                                @keydown.enter="onTabSearch"--}}
{{--                                type="text"--}}
{{--                                id="searchInput"--}}
{{--                                placeholder="Search Client..."--}}
{{--                                class="w-4/5 px-4 py-2 border rounded shadow-sm focus:outline-none focus-visible:ring-0"--}}
{{--                         />--}}
{{--                        <button :disabled="search.trim()===''"--}}
{{--                                class="w-1/5 text-white bg-gray-400 border mx-0.5 rounded shadow-sm"--}}
{{--                                @click="onTabSearch">@{{ searchBtn }}--}}
{{--                        </button>--}}
{{--                     </span>--}}
{{--                </div>--}}
{{--                <div v-if="isEmpty" class="text-center text-gray-500 text-lg py-4">--}}
{{--                    No Data Found!--}}
{{--                </div>--}}
{{--                <div v-else>--}}
{{--                <div v-if="loading" class="flex justify-center items-center h-32">--}}
{{--                    <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-500"></div>--}}
{{--                </div>--}}
{{--                <table v-else class="min-w-full divide-y divide-gray-200 text-xs md:text-sm lg:text-md"--}}
{{--                       id="customersList">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th class="p-1.5">#</th>--}}
{{--                        <th>Client Name</th>--}}
{{--                        <th>Phone</th>--}}
{{--                        <th>Email</th>--}}
{{--                        --}}{{--                <th>&nbsp;</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}

{{--                    <tbody class="divide-y divide-gray-400 text-sm text-gray-800">--}}
{{--                    <template v-for="(customer, index) in customers" :key="customer.id">--}}
{{--                        <tr class="list hover:bg-gray-50 text-center" onclick="toggleDetails(this)">--}}
{{--                            <td class="w-4 p-1.5">@{{++index}}</td>--}}
{{--                            <td>@{{customer.name}}</td>--}}
{{--                            <td>@{{customer.phone}}</td>--}}
{{--                            <td>@{{customer.email}}</td>--}}
{{--                        </tr>--}}

{{--                        <tr class="details-row hidden bg-gray-50">--}}
{{--                            <td colspan="6" class="px-3 py-2">--}}
{{--                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">--}}
{{--                                    <div--}}
{{--                                        class="col-span-1 lg:col-span-1 text-xs sm:text-sm align-content-start text-left">--}}
{{--                                        <div><b>Name:</b> @{{customer.name}} <i class="fa fa-angle-right"></i><span--}}
{{--                                                class="font-semibold">UID : @{{  customer.id}}</span></div>--}}
{{--                                        <div><b>Phone:</b> @{{customer.phone}}</div>--}}
{{--                                        <div><b>Email:</b> @{{customer.email}}</div>--}}
{{--                                    </div>--}}

{{--                                    <div--}}
{{--                                        class="col-span-1 lg:col-span-1 text-xs sm:text-sm align-content-start text-left">--}}
{{--                                        <div><b>Address:</b> @{{customer.address}}</div>--}}
{{--                                        <div><b>Date:</b> @{{customer.created_at}}</div>--}}
{{--                                        --}}{{--                                <div><strong>Due:</strong> @{{invoice.total_amount - invoice.paid_amount}}</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-span-2 lg:col-span-1 justify-center items-center">--}}
{{--                                        <a :href="goto(customer.id)"--}}
{{--                                           class="bg-blue-500 text-white px-3 py-1 rounded text-xs">--}}
{{--                                            <i class="fa fa-eye"></i> View</a>--}}

{{--                                        <a :href="goto_edit(customer.id)"--}}
{{--                                           class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">--}}
{{--                                            <i class="fa fa-edit"></i> Edit</a>--}}

{{--                                        <button class="bg-red-500 text-white px-3 py-1 rounded text-xs"--}}
{{--                                                @click="confirmDelete(customer.id)">--}}
{{--                                            <i class="fa fa-trash"></i> Delete--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    </template>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--                <!-- Pagination Controls -->--}}
{{--                <div class="flex gap-2 mt-4">--}}
{{--                    <button @click="fetchCustomers(pagination.prev_page_url)"--}}
{{--                            :disabled="!pagination.prev_page_url" class="px-4 py-2 bg-gray-300 rounded">Prev--}}
{{--                    </button>--}}

{{--                    <button @click="fetchCustomers(pagination.next_page_url)"--}}
{{--                            :disabled="!pagination.next_page_url" class="px-4 py-2 bg-gray-300 rounded">Next--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </main>--}}
{{--</div>--}}
{{--@include('custom-layouts.footer')--}}
{{--</body>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
{{--</html>--}}
<script>

    function toggleDetails(row) {
        // Hide all other detail rows first
        document.querySelectorAll("tr").forEach(th => th.classList.remove("active"));
        row.classList.add("active")
        document.querySelectorAll(".details-row").forEach(r => r.classList.add("hidden"));
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains("details-row")) {
            // Toggle only the one after the clicked row
            nextRow.classList.toggle("hidden");
        }
    }
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

</x-dashboard-layout>
