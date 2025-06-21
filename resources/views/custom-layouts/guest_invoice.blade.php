@if(session('message'))
    <div class="text-center text-sm text-green-400">
        {{ session('message') }}
    </div>
@endif

<div id="app" class="w-full xl:max-w-6xl py-1 px-1  xl:mx-auto">
    <div class="grid grid-cols-4 py-1">
        <div class=" col-span-4 md:col-span-3 p-4 md:px-4">
            <div class="shadow-lg p-4 md:p-2 w-full lg:w-10/12 max-w-3xl m-auto">
                <div class="invoice-header flex-row justify-between px-4">
                    <div class="company-name text-lg text-gray-500" id="company_name">
                        <p>Invoice ID : <input contenteditable="true" v-model="invoiceId" class="w-32 text-sm h-8"></p>
                    </div>
                    <div class="text-gray-500" >
                        <span>Issue Date : <input v-model:="invoiceDate" id="date" type="text" class="w-32 h-8 datepicker"
                                         placeholder="select"></span>
                    </div>
                </div>

                <div class="grid grid-cols-2  mt-2 w-full">
                    <div class="px-4 w-full space-y-2">
                        <p class="text-gray-500 text-sm">Issue To :</p>
                        <input v-model="issueTo" id="issueTo" type="text" class="w-9/12 mt-2 h-8"
                               placeholder="Name / Issue To">
                        <input v-model="address" id="address" type="text" class="w-9/12 h-8"
                               placeholder="Address">
                        <input v-model="contactNumber" id="ContactNumber" list="number_list" type="text"
                               class="w-9/12 mt-2 h-8" placeholder="Contact Number">
                        <input v-show="showEmail" v-model="email" id="email" type="text" class="w-9/12 h-8"
                               placeholder="Email">
                    </div>

                    <div class="px-4 flex flex-col items-end space-y-2">
                        <p class="text-gray-500 text-sm w-9/12">Issue From :</p>
                        <input v-model="issueFrom" id="issueFrom" type="text" class="w-9/12 h-8"
                               placeholder="Company Name">
                        <input v-model="issueAddress" id="issueFrom" type="text" class="w-9/12 h-8"
                               placeholder="Address">
                        <input v-model="issuePhone" id="number_from" type="text" class="w-9/12 h-8"
                               placeholder="Contact Number">
                        <input v-show="showEmail" v-model="issueEmail" id="email_from" type="text" class="w-9/12 h-8"
                               placeholder="Email">

                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200 text-xs md:text-sm lg:text-base my-4">
                    <thead class="p-1.5">
                    <tr class="bg-gray-100">
                        <th class="p-1.5">Item</th>
                        <th class="p-1.5">Quantity</th>
                        <th class="p-1.5">Rate</th>
                        <th class="p-1.5 text-right">Amount</th>
                        <th class="p-1.5"></th>
                    </tr>
                    </thead>
                    <tbody id="invoice-items" class="divide-y divide-gray-400 text-sm text-gray-800">
                    <tr v-for="(item, index) in items" :key="index">
                        <td class="py-1.5">
                            <input v-model="item.name" class="min-w-full border-0 text-sm" type="text"
                                   placeholder="Description of item/service..."></td>
                        <td class="p-1.5 w-40 text-center">
                            <input v-model.number="item.qty" class="w-full border-0 text-sm text-center" type="text"
                                   value="1"></td>
                        <td class="p-1.5 w-40 text-center">
                            <input v-model.number="item.rate" class="w-full border-0 text-sm text-center" type="text"
                                   value="0"></td>
                        <td class="p-1.5 w-40 text-right text-sm">@{{ (item.qty * item.rate).toFixed(2) }}</td>
                        <td class="w-10 py-1.5 flex justify-end items-center text-base">
                            <i class="p-1.5 fa fa-trash text-red-500 cursor-pointer ml-2 hover:text-red-700"
                               @click="removeItem(index)"></i>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <button class="text-sm bg-color-main px-3 py-2 shadow-sm text-white rounded-md" @click="addItem">+
                    Item +
                </button>
                <div class="flex justify-between">
                    <div class="mt-3 w-full px-2">
                        <textarea id="invoiceNotes" rows="2" v-model="notes" class="w-full text-base text-gray-400"
                                  placeholder="Write any notes about this invoice"></textarea>
                    </div>
                    <div class="mt-3 flex justify-end w-full px-2">
                        <div class="w-full max-w-80 divide-y divide-gray-200">
                            <div v-show="showTax" id="subtotalBox" class="flex justify-between py-0.5">
                                <span>Subtotal :</span> <span
                                    id="subtotal">@{{ subtotal.toFixed(2) }} @{{ currency }}</span>
                            </div>
                            <div v-show="showTax" id="taxBox" class="flex justify-between py-0.5">
                                <p>Tax(%) : </p>
                                <input v-model.number="tax_amount" type="number" id="tax" value="0"
                                       class="h-8 w-16 text-center">
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span>Total :</span> <span id="total">@{{ total.toFixed(2) }} @{{ currency }}</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <p>Amount Paid :</p>
                                <input v-model.number="paid" type="number" id="paid" value="0"
                                       class="h-8 w-[calc(8rem)] max-w-48">
                            </div>
                            <div class="flex justify-between py-0.5">
                                <p>Balance Due :</p> <span id="balance">@{{ balance.toFixed(2) }} @{{ currency }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--                    side section--}}
        <div class="col-span-1">
            <div class="w-full xl:w-64 lg:mx-auto side-panel text-xs lg:text-sm px-0.5 lg:px-4">
                <div class="mt-3">
                    <div class="edit-section">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="emailInputCheck"
                                   v-model="showEmail">
                            <label class="form-check-label" for="emailInputCheck">
                                add email input
                            </label>
                        </div>
                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="taxField" v-model="showTax">
                            <label class="form-check-label" for="taxField">
                                Include Tax Field
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="currency">Currency:</label>
                    <select id="currency" class="w-full" v-model="currency">
                        <option value="BDT">BDT</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button id="save_btn" class="dl-btn" :class="{'opacity-50 cursor-not-allowed': isDisabled}"
                            @click="saveInvoice">Print preview
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

    flatpickr(".datepicker", {});

    const {createApp, ref, computed, onMounted,} = Vue;

    createApp({
        setup() {
            const issueFrom = ref('');
            const issueAddress = ref('');
            const issuePhone = ref('');
            const issueEmail = ref('');

            const invoiceId = ref('{{$invoiceId}}');
            const invoiceDate = ref('');

            const issueTo = ref('');
            const address = ref('');
            const contactNumber = ref('');
            const email = ref('');
            const showEmail = ref(false);
            const showTax = ref(false);

            const tax_amount = ref(0);
            const tax = computed(() => showTax.value ? tax_amount.value : 0);
            const paid = ref(0);
            const currency = ref('USD');
            const notes = ref('');
            const items = ref([{name: '', qty: 1, rate: 0}]);
            const isDisabled = ref(false);

            const subtotal = computed(() =>
                items.value.reduce((acc, item) => acc + (item.qty * item.rate), 0)
            );
            const taxAmount = computed(() => (subtotal.value * tax.value) / 100);
            const total = computed(() => subtotal.value + taxAmount.value);
            const balance = computed(() => total.value - paid.value);

            const addItem = () => items.value.push({name: '', qty: 1, rate: 0});
            const removeItem = (index) => items.value.splice(index, 1);
            onMounted(() => {
                flatpickr('.datepicker', {
                    dateFormat: "Y-m-d",
                    defaultDate: new Date(),
                    allowInput: true,
                });
            });

            const saveInvoice = () => {
                const data = {
                    issueFrom: issueFrom.value,
                    issueAddress:issueAddress.value,
                    issuePhone:issuePhone.value,
                    issueEmail:issueEmail.value,

                    invoice_number: invoiceId.value,
                    invoice_date: invoiceDate.value,

                    name: issueTo.value,
                    address: address.value,
                    phone: contactNumber.value,
                    email: email.value,

                    currency: currency.value,
                    notes: notes.value,
                    items: items.value,
                    tax_amount: tax.value,
                    subtotal: subtotal.value,
                    total_amount: total.value,
                    paid_amount: paid.value,
                    balance: balance.value,
                    need_tax: showTax.value
                };
                let server = new serverRequest();
                server.url = '/invoice/create';
                server.data = data;
                isDisabled.value = true;
                server.xPost().then((res) => {
                    if (res.success && res.redirect) {
                        window.location.href = res.redirect;
                    }
                    if (!res.success) {
                        alert(res.message);
                    }
                    isDisabled.value = false;
                    // console.log(res)
                });

                //  console.log('Invoice data:', data);
                //alert('Invoice saved (see console)');
            };

            return {
                issueFrom, issueAddress,issuePhone,issueEmail, invoiceId, invoiceDate, issueTo, address, contactNumber, email, showEmail,
                tax, paid, currency, notes, items, subtotal, taxAmount, total, balance, showTax, isDisabled,
                tax_amount,
                addItem, removeItem, saveInvoice
            };
        }
    }).mount('#app');
</script>
