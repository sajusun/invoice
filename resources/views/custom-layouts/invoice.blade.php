@if(session('message'))
    <div class="text-center text-sm text-green-400">
        {{ session('message') }}
    </div>
@endif

<div id="app" class="w-full xl:max-w-6xl py-1 px-1  xl:mx-auto text-xs md:text-sm lg:text-base">
    <div class="grid grid-cols-4 py-1">
        <div class=" col-span-4 md:col-span-3 md:px-4">
            <div class="shadow-lg py-4 px-2 md:p-2 w-full lg:w-10/12 max-w-3xl m-auto">
                <div class="invoice-header flex-row justify-between px-2 py-1 shadow-sm border-b h-16">
                    <div class="company-name text-gray-500">
                        <p> Invoice ID: <span class="w-full h-8">@{{invoiceId}}</span></p>
                    </div>
                    <div class="text-gray-500 lg:text-lg">
                        <input v-model:="invoiceDate" id="date" type="text"
                               class="text-xs lg:text-base w-full lg:w-full h-8 datepicker"
                               placeholder="Select" required>
                    </div>
                </div>

                <div class="grid grid-cols-2  mt-3 w-full text-gray-600">
                    <div class="px-2 w-full space-y-2">
                        <input v-model="issueTo" id="issueTo" type="text"
                               class="text-xs lg:text-base w-full h-8 lg:w-72"
                               placeholder="Name / Issue To" required>
                        <input v-model="address" id="address" type="text"
                               class="text-xs lg:text-base w-full h-8 lg:w-72"
                               placeholder="Address" required>
                    </div>

                    <div class="px-4 flex flex-col items-end space-y-2">
                        <input v-model="contactNumber" id="ContactNumber" list="number_list" type="text"
                               class="text-xs lg:text-base w-full lg:w-72  h-8" placeholder="Contact Number" required>
                        <datalist id="number_list">

                        </datalist>
                        <input v-show="showEmail" v-model="email" id="email" type="text"
                               class="text-xs lg:text-base w-full h-8"
                               placeholder="Email">
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200 text-xs md:text-sm lg:text-base px-4 my-4">
                    <thead class="p-1.5">
                    <tr class="bg-gray-300">
                        <th class="p-1.5 text-left">Description</th>
                        <th class="p-1.5">Qty</th>
                        <th class="p-1.5">Price</th>
                        <th class="p-1.5 text-right">Amount</th>
                    </tr>
                    </thead>
                    <tbody id="invoice-items" class="divide-y divide-gray-400 text-gray-800">
                    <tr v-for="(item, index) in items" :key="index" class="space-y-2">
                        <td class="">
                            <input v-model="item.name"
                                   class="text-xs md:text-sm lg:text-base max-w-2/5 w-full h-8 border-0 py-0 px-0.5 bg-inherit"
                                   type="text"
                                   placeholder="Description">
                        </td>
                        <td class="px-2">
                            <input v-model.number="item.qty"
                                   class="text-xs md:text-sm lg:text-base w-full h-8 border-0 py-0 px-0.5 bg-inherit text-center max-w-16"
                                   type="text"
                                   value="1">
                        </td>
                        <td class="pr-2">
                            <input v-model.number="item.rate"
                                   class="text-xs md:text-sm lg:text-base w-full max-w-24 h-8 border-0 py-0 px-0.5 bg-inherit text-center outline-none"
                                   type="text"
                                   value="0">
                        </td>
                        <td class=" text-right h-8 text-xs md:text-sm lg:text-base bg-inherit align-middle flex justify-end mr-1">
                            <span class="mr-2 w-full">@{{ (item.qty * item.rate).toFixed(2) }}</span>
                            <i class="fa fa-trash text-red-500 cursor-pointer
                             hover:text-red-700 text-xs md:text-sm lg:text-base"
                               @click="removeItem(index)"></i>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <button class="text-xs md:text-sm lg:text-lg bg-inherit text-gray-500 px-2 py-0.5
                md:px-4 md:py-1 rounded-full shadow-md hover:shadow border transition translate-x-1
                 border-gray-400 font-semibold" @click="addItem">
                    <i class="fa-sharp fa-solid fa-plus text-green-600"></i>
                </button>
                <div class="flex-1 md:flex md:justify-between">
                    <div class="mt-3 w-full px-2">
                        <textarea id="invoiceNotes" rows="2" v-model="notes"
                                  class="w-full text-xs md:text-sm lg:text-base text-gray-400"
                                  placeholder="Write any notes about this invoice"></textarea>
                    </div>
                    <div class="mt-3 flex justify-end w-full md:w-full px-2">
                        <div class="w-full max-w-80 divide-y divide-gray-200">
                            <div v-show="showTax" id="subtotalBox" class="flex justify-between py-0.5">
                                <span>Subtotal :</span> <span
                                    id="subtotal">@{{ subtotal.toFixed(2) }} @{{ currency }}</span>
                            </div>
                            <div v-show="showTax" id="taxBox" class="flex justify-between py-0.5">
                                <p>Tax(%) : </p>
                                <input v-model.number="tax_amount" type="text" id="tax" value="0"
                                       class="h-8 w-20 md:w-16 text-center text-xs md:text-sm lg:text-base">
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span>Total :</span> <span id="total">@{{ total.toFixed(2) }} @{{ currency }}</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <p>Amount Paid :</p>
                                <input v-model.number="paid" type="text" id="paid" value="0"
                                       class="md:w-16 text-center text-xs md:text-sm lg:text-base h-8 w-24">
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
        <div class="lg:col-span-1 w-screen md:w-full">
            <div class="w-full px-8 xl:w-64 lg:mx-auto side-panel text-xs lg:text-sm md:px-0.5 lg:px-4">
                <div class="mt-3">
                    <div class="edit-section space-y-1">
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
                <div class="mt-3 w-full">
                    <label for="currency">Currency:</label>
                    <select id="currency" class="w-full text-xs md:text-sm lg:text-base rounded" v-model="currency">
                        <option value="BDT">BDT</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                    </select>
                </div>
                <div class="mt-3">
                    @auth()
                        <button id="save_btn"
                                class="py-2 px-4 w-full text-xs md:text-sm lg:text-base text-white bg-green-600 rounded"
                                :class="{'opacity-50 cursor-not-allowed': isDisabled}"
                                @click="saveInvoice">Save & preview
                        </button>
                    @else
                        <button id="dl_btn" class="dl-btn" onclick="save()">Preview</button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>

    // flatpickr(".datepicker", {});
    const {createApp, ref, computed, onMounted,} = Vue;

    createApp({
        setup() {
            const issueFrom = ref('');
            const invoiceId = ref('{{$invoiceId}}');
            let invoiceDate = ref('');

            const issueTo = ref('');
            const address = ref('');
            const contactNumber = ref('');
            const email = ref('');
            const showEmail = ref(Boolean({{$settings?$settings->show_email_column:''}}));
            const showTax = ref(Boolean({{$settings->show_tax_column}}));

            const tax_amount = ref({{$settings->default_tax_rate}});
            const tax = computed(() => showTax.value ? tax_amount.value : 0);
            const paid = ref(0);
            const currency = ref('{{$settings->default_currency}}');
            const notes = ref('');
            const items = ref([{name: '', qty: 1, rate: 0}]);
            const isDisabled = ref(false);

            let fp = null;
            const subtotal = computed(() =>
                items.value.reduce((acc, item) => acc + (item.qty * item.rate), 0)
            );
            const taxAmount = computed(() => (subtotal.value * tax.value) / 100);
            const total = computed(() => subtotal.value + taxAmount.value);
            const balance = computed(() => total.value - paid.value);

            const addItem = () => items.value.push({name: '', qty: 1, rate: 0});
            const removeItem = (index) => items.value.splice(index, 1);

            onMounted(() => {
                fp = flatpickr(".datepicker", {
                    dateFormat: "Y-m-d",
                    defaultDate: new Date(),
                    allowInput: true,
                    onChange: (selectedDates, dateStr) => {
                        invoiceDate.value = dateStr; // keep Vue state updated
                    },
                });
                invoiceDate.value = fp.input.value;
            });
            const saveInvoice = () => {
                const data = {
                    issueFrom: issueFrom.value,
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
            };
            return {
                issueFrom, invoiceId, invoiceDate, issueTo, address, contactNumber, email, showEmail,
                tax, paid, currency, notes, items, subtotal, taxAmount, total, balance, showTax, isDisabled,
                tax_amount,
                addItem, removeItem, saveInvoice
            };
        }
    }).mount('#app');
</script>
