<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <!-- Total Invoices -->
    <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
        <p class="text-gray-500 text-sm">Total Invoices</p>
        <p class="sm:text-lg md:text-2xl sm:mt-1 md:mt-2 font-bold text-green-600">{{$num_of_invoices}}</p>
    </div>

    <!-- Pending Invoices -->
    <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
        <p class="text-gray-500 text-sm">Pending Invoices</p>
        <p class="sm:text-lg md:text-2xl sm:mt-1 md:mt-2 font-bold text-green-600">{{$status}}</p>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white shadow rounded-xl p-2 border border-gray-100">
        <p class="text-gray-500 text-sm">Total Revenue</p>
        <p class="sm:text-lg md:text-2xl sm:mt-1 md:mt-2 font-bold text-green-600">{{$total}}</p>
    </div>
</div>
<div id="app" class="mt-4 list-view">
    <div class="flex py-1">
        <h4 class="text-sm md:text-base font-semibold w-1/5 md:w-2/5 flex items-center">Invoice List  </h4>
        <span class="flex w-4/5 md:w-3/5 mr-1 text-xs sm:text-sm md:text-base h-8 md:h-10">
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
    <table v-else class="table text-xs md:text-sm lg:text-md" id="recentInvoice">
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
                <td colspan="6" class="px-1 py-2">
                    <div class="flex justify-around">
                        <div class="text-xs sm:text-sm align-content-start text-left">
                            <div><b>Name:</b> @{{invoice.customer.name}}</div>
                            <div><b>Phone:</b> @{{invoice.customer.phone}}</div>
                            <div><b>Email:</b> @{{invoice.customer.email}}</div>

                        </div>
                        <div class="text-xs sm:text-sm align-content-start text-left">
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
        <button @click="fetchInvoices(pagination.prev_page_url)" :disabled="!pagination.prev_page_url" class="text-sm px-4 py-2 bg-gray-300 rounded">Prev</button>
        <button @click="fetchInvoices(pagination.next_page_url)" :disabled="!pagination.next_page_url" class=" text-sm px-4 py-2 bg-gray-300 rounded">Next</button>
    </div>
</div>
