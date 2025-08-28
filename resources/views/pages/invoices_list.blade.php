<div class="w-full xl:max-w-5xl py-1 px-1  xl:pl-10">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <!-- Total Invoices -->
        <div class="bg-white shadow rounded-xl p-2 border border-gray-100 space-y-1">
            <p class="text-green-500 text-sm border-b shadow-sm p-1 bg-gray-200">Total Invoices
                : {{$num_of_invoices}}</p>
            <p class="text-white text-sm border-b shadow-sm p-1 bg-green-500 rounded">Paid : {{$paid}}</p>

        </div>

        <!-- Pending Invoices -->
        <div class="bg-white shadow rounded-xl p-2 border border-gray-100 space-y-1">
            <p class="text-black text-sm border-b shadow-sm p-1 bg-yellow-500 rounded">Pending : {{$pending}}</p>
            <p class="bg-gray-500 text-white text-sm border-b shadow-sm p-1 rounded">Cancelled : {{$canceled}}</p>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white shadow rounded-xl p-2 border border-gray-100 space-y-1">
            <p class="text-white text-sm bg-green-500 p-1 rounded border-b shadow">Total Revenue
                : {{$total}} {{$currency}} </p>
            <p class="text-red-500 text-sm bg-gray-200 p-1 rounded border-b shadow">Total Due
                : {{$due}} {{$currency}}</p>
{{--            <p class="sm:text-lg md:text-2xl sm:mt-1 md:mt-2 font-bold text-green-600">{{$total}}</p>--}}
        </div>
    </div>
    <div id="app" class="mt-4 list-view shadow">
        <div class="flex py-1 justify-between border-b">
            <h4 class="text-xs md:text-base font-semibold mx-4 flex items-center"></h4>
            <span class="flex md:w-3/5 mr-1 text-xs sm:text-sm lg:text-base h-8 md:h-10">
                <input v-model="search" @input="key_Searching" @keydown.enter="onTabSearch"
                       type="text"
                       id="searchInput"
                       placeholder="Search..."
                       class="w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus-visible:ring-0"
                />
                <button :disabled="search.trim()===''"
                        class="text-white bg-gray-400 border mx-0.5 px-2 md:px-4 rounded shadow-sm" @click="onTabSearch">@{{ searchBtn }}</button>
            </span>

        </div>
        <div v-if="isEmpty" class="text-center text-gray-500 text-xs md:text-sm lg:text-base py-4">
            No Data Found!
        </div>
        <div v-else class="shadow pb-4">
            <div v-if="loading" class="flex justify-center items-center h-32">
                <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-500"></div>
            </div>
            <table v-else class="min-w-full divide-y divide-gray-200 text-xs md:text-sm lg:text-md" id="recentInvoice">
                <thead>
                <tr>
                    <th class="p-1.5">#</th>
                    <th>Invoice</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-400 text-gray-800">
                <template v-for="(invoice, index) in invoices" :key="invoice.id">
                    <tr :href="invoice.invoice_number" class="list text-center" onclick="toggleDetails(this)">
                        <td class="w-4 p-1.5">@{{++index}}</td>
                        <td class="">@{{invoice.invoice_number}}</td>
                        <td>@{{invoice.customer.name}}</td>
                        <td>@{{invoice.total_amount}}</td>
                        <td>
                            <span v-if="invoice.status==='Pending'" class="bg-yellow-500 px-3 py-1 text-white rounded">@{{invoice.status}}</span>
                            <span v-else-if="invoice.status==='Paid'" class="bg-green-500 px-3 py-1 text-white rounded">@{{invoice.status}}</span>
                            <span v-else class="bg-gray-500 px-3 py-1 text-white rounded">@{{invoice.status}}</span>
                        </td>
                    </tr>

                    <tr class="details-row hidden bg-gray-50">
                        <td colspan="6" class="px-1 py-2">
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="col-span-1 lg:col-span-1 text-xs sm:text-sm align-content-start text-left">
                                    <div><b>Name:</b> @{{invoice.customer.name }} <i class="fa fa-angle-right"></i>
                                        <span class="font-semibold"> UID : </span>@{{ invoice.customer.id}}
                                    </div>
                                    <div><b>Phone:</b> @{{invoice.customer.phone}}</div>
                                    <div><b>Email:</b> @{{invoice.customer.email}}</div>

                                </div>
                                <div class="col-span-1 lg:col-span-1 text-xs sm:text-sm align-content-start text-left">
                                    <div><b>Address:</b> @{{invoice.customer.address}}</div>
                                    <div><b>Date:</b> @{{invoice.invoice_date}}</div>
                                    <div><strong>Due:</strong> @{{invoice.total_amount - invoice.paid_amount}}</div>
                                </div>
                                <div class="col-span-2 lg:col-span-1 justify-center items-center">
                                    <a :href="goto(invoice.invoice_number)"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                        <i class="fa fa-eye"></i> View</a>

                                    <b href="#" @click="edit_invoice(invoice.invoice_number,invoice.status)"
                                       class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">
                                        <i class="fa fa-edit"></i> Edit</b>

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
            <!-- Pagination Controls -->
            <div class="flex gap-2 mt-4 text-xs sm:text-sm lg:text-base px-4">
                <button @click="fetchInvoices(pagination.prev_page_url)" :disabled="!pagination.prev_page_url"
                        class="px-2 py-0.5 md:px-4 md:py-1 bg-gray-300 rounded">Prev
                </button>
                <button @click="fetchInvoices(pagination.next_page_url)" :disabled="!pagination.next_page_url"
                        class="px-2 py-0.5 md:px-4 md:py-1 bg-gray-300 rounded">Next
                </button>
            </div>
        </div>
        <!-- Modal -->
        <div class="fixed inset-0 items-center justify-center bg-black bg-opacity-50"
             :class="openModal?'flex':'hidden'">
            <div class="bg-white w-11/12 max-w-md p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Change Payment Status</h2>
                <form method="get" action="{{route('changeStatus')}}">
                    @csrf
                    <input class="hidden" name="id" :value="invoice_id">
                    <select id="paymentStatus" class="w-full border border-gray-300 rounded p-2 cursor-pointer"
                            name="paymentStatus">
                        <option value="Pending" class="bg-yellow-500 py-1 text-white rounded h-8"
                                :selected="status=='Pending'">Pending
                        </option>
                        <option value="Paid" class="bg-green-500 py-1 text-white rounded" :selected="status=='Paid'">
                            Paid
                        </option>
                        <option value="Cancelled" class="bg-gray-500x py-1 text-white rounded"
                                :selected="status=='Cancelled'">Cancelled
                        </option>
                    </select>
                    <div class="flex justify-end mt-6 space-x-3">
                        <button @click="openModal = false"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
