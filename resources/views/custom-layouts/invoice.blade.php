@if(session('message'))
    <div class="text-center text-sm text-green-400">
        {{ session('message') }}
    </div>
@endif


{{--<div id="app" class="w-full max-w-6xl mx-auto bg-white p-5 shadow-lg rounded">--}}

{{--    <div class="flex justify-between items-center mb-5">--}}
{{--        <h1 class="text-2xl font-bold" contenteditable="true">@{{ companyName }}</h1>--}}
{{--        <div class="text-right">--}}
{{--            <h2 class="text-xl font-bold">INVOICE</h2>--}}
{{--            <input v-model="invoiceId" type="text" class="border p-1 text-sm mt-1" placeholder="Invoice ID">--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="grid grid-cols-2 gap-4 mb-5">--}}
{{--        <div>--}}
{{--            <h3 class="font-semibold mb-1">From:</h3>--}}
{{--            <input v-model="from" type="text" class="border w-full p-1 mb-2" placeholder="Sender name">--}}
{{--            <input v-model="address" type="text" class="border w-full p-1 mb-2" placeholder="Sender address">--}}
{{--            <input v-model="contactNumber" type="text" class="border w-full p-1 mb-2" placeholder="Contact number">--}}
{{--            <input v-if="showEmail" v-model="email" type="text" class="border w-full p-1 mb-2" placeholder="Email">--}}
{{--        </div>--}}
{{--        <div>--}}
{{--            <h3 class="font-semibold mb-1">Bill To:</h3>--}}
{{--            <input v-model="to" type="text" class="border w-full p-1 mb-2" placeholder="Customer name">--}}
{{--            <input v-model="invoiceDate" type="text" class="border w-full p-1 mb-2" placeholder="Invoice date">--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <table class="w-full text-left border mb-5">--}}
{{--        <thead class="bg-gray-100">--}}
{{--        <tr>--}}
{{--            <th class="p-2 border">Item</th>--}}
{{--            <th class="p-2 border">Qty</th>--}}
{{--            <th class="p-2 border">Rate</th>--}}
{{--            <th class="p-2 border text-right">Amount</th>--}}
{{--            <th class="p-2 border"></th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr v-for="(item, index) in items" :key="index" class="border-b">--}}
{{--            <td class="p-2 border"><input v-model="item.name" type="text" class="border p-1 w-full"></td>--}}
{{--            <td class="p-2 border"><input v-model.number="item.qty" type="number" class="border p-1 w-16"></td>--}}
{{--            <td class="p-2 border"><input v-model.number="item.rate" type="number" class="border p-1 w-24"></td>--}}
{{--            <td class="p-2 border text-right">@{{ (item.qty * item.rate).toFixed(2) }}</td>--}}
{{--            <td class="p-2 border text-center">--}}
{{--                <button @click="removeItem(index)" class="text-red-600">×</button>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}

{{--    <button @click="addItem()" class="bg-blue-500 text-white px-4 py-1 rounded mb-5">+ Item</button>--}}

{{--    <div class="grid grid-cols-2 gap-4 mb-5">--}}
{{--        <div>--}}
{{--            <h3 class="font-semibold">Notes:</h3>--}}
{{--            <textarea v-model="notes" class="border w-full p-2" placeholder="Invoice notes..."></textarea>--}}
{{--        </div>--}}
{{--        <div class="space-y-2">--}}
{{--            <div class="flex justify-between">--}}
{{--                <span>Subtotal:</span>--}}
{{--                <span>@{{ subtotal.toFixed(2) }} @{{ currency }}</span>--}}
{{--            </div>--}}
{{--            <div class="flex justify-between">--}}
{{--                <span>Tax (%)</span>--}}
{{--                <input v-model.number="tax" type="number" class="border p-1 w-20 text-center">--}}
{{--            </div>--}}
{{--            <div class="flex justify-between">--}}
{{--                <span>Tax Amount:</span>--}}
{{--                <span>@{{ taxAmount.toFixed(2) }} @{{ currency }}</span>--}}
{{--            </div>--}}
{{--            <div class="flex justify-between font-semibold">--}}
{{--                <span>Total:</span>--}}
{{--                <span>@{{ total.toFixed(2) }} @{{ currency }}</span>--}}
{{--            </div>--}}
{{--            <div class="flex justify-between">--}}
{{--                <span>Paid:</span>--}}
{{--                <input v-model.number="paid" type="number" class="border p-1 w-24 text-center">--}}
{{--            </div>--}}
{{--            <div class="flex justify-between font-semibold">--}}
{{--                <span>Balance:</span>--}}
{{--                <span>@{{ balance.toFixed(2) }} @{{ currency }}</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="flex items-center space-x-2">--}}
{{--        <label><input type="checkbox" v-model="showEmail"> Show Email Input</label>--}}
{{--        <select v-model="currency" class="border p-1">--}}
{{--            <option value="BDT">BDT</option>--}}
{{--            <option value="USD">USD</option>--}}
{{--            <option value="EUR">EUR</option>--}}
{{--        </select>--}}
{{--        <button @click="saveInvoice()" class="bg-green-600 text-white px-4 py-1 rounded">Save & Preview</button>--}}
{{--    </div>--}}

{{--</div>--}}

<div id="app" class="w-full xl:max-w-6xl py-1 px-1  xl:mx-auto">
    <div class="grid grid-cols-4 py-5">
        <div class=" col-span-4 md:col-span-3 p-4 md:px-4">
            <div class="shadow-lg p-4 md:p-2 w-full lg:w-10/12 max-w-3xl m-auto">
                <div class="invoice-header flex-row justify-between px-4">
                    <div class="company-name text-2xl" id="company_name">
                        @auth()
                            <p class="company-name" id="company_name">{{$settings->getCompanyName()}}</p>
                        @else
                            <p class="company-name" id="company_name" contenteditable="true">@{{ companyName }}</p>
                        @endauth
                    </div>
                    <div>
                        <h2>INVOICE</h2>
                        <input v-model="invoiceId" type="text" class="w-75 text-sm "
                               placeholder="InvoiceID" value="#{{$invoiceId}}">
                    </div>
                </div>

                <div class="grid grid-cols-2  mt-3 w-full">
                    <div class="px-4 w-full">
                        <input v-model="from" id="issueFrom" type="text" class="w-9/12 lg:w-72" placeholder="Who is this from?">
                        <input v-model="to" id="issueTo" type="text" class="w-9/12 lg:w-72 mt-2" placeholder="Who is this to?">
                        <input v-model="address" id="address" type="text" class="w-9/12 lg:w-72  mt-2" placeholder="address">
                    </div>

                    <div class="px-4 flex flex-col items-end">
                        <input v-model="invoiceDate" id="date" type="date" class="w-9/12" placeholder="Date">
                        <input v-model="contactNumber" id="ContactNumber" list="number_list" type="text"
                               class="w-9/12 mt-2" placeholder="Contact Number">
                        <datalist id="number_list">
                            <option value="0170"></option>
                            <option value="0171"></option>
                            <option value="0181"></option>
                        </datalist>
                        <input v-show="showEmail" v-model="email" id="email" type="text" class="w-9/12 mt-2" placeholder="Email Address">
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
                            <input v-model="item.name" class="min-w-full border-0 text-sm" type="text" placeholder="Description of item/service..."></td>
                        <td class="p-1.5 w-40 text-center">
                            <input v-model.number="item.qty" class="w-full border-0 text-sm text-center" type="text" value="1" onchange="calculateTotal()"></td>
                        <td class="p-1.5 w-40 text-center">
                            <input v-model.number="item.rate" class="w-full border-0 text-sm text-center" type="text" value="0" onchange="calculateTotal()"></td>
                        <td class="p-1.5 w-40 text-right text-sm">@{{ (item.qty * item.rate).toFixed(2) }}</td>
                        <td class="w-10 py-1.5 flex justify-end items-center text-base">
                            <i class="p-1.5 fa fa-trash text-red-500 cursor-pointer ml-2 hover:text-red-700" @click="removeItem(index)"></i>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <button class="text-sm bg-color-main px-3 py-2 shadow-sm text-white rounded-md" @click="addItem">+
                    Item +
                </button>
                <div class="mt-3">
                    <h5>Terms</h5>
                    <textarea id="invoiceNotes" v-model="notes" class="w-[60%]" placeholder="Invoice Notes"></textarea>
                </div>
                <div class="mt-3 flex justify-end">
                    <div class="w-full max-w-80 divide-y divide-gray-200">
                        <div v-show="showTax" id="subtotalBox" class="flex justify-between py-0.5">
                            <span>Subtotal :</span> <span id="subtotal">@{{ subtotal.toFixed(2) }} @{{ currency }}</span>
                        </div>
                        <div v-show="showTax" id="taxBox" class="flex justify-between py-0.5">
                            <p>Tax(%) : </p>
                            <input v-model.number="tax" type="number" id="tax" value="0"
                                   class="h-8 w-16 text-center" >
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


{{--            side section--}}
        <div class="col-span-1">
            <div class="w-full xl:w-64 lg:mx-auto side-panel text-xs lg:text-sm px-0.5 lg:px-4">
                <div class="mt-3">
                    <div class="edit-section">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="emailInputCheck" v-model="showEmail">
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

                    @auth()
                        <button id="save_btn" class="dl-btn" onclick="save()">Save & preview</button>
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

    {{--function getCurrency() {--}}
    {{--    return document.getElementById("currency").value;--}}
    {{--}--}}

    // function addItem() {
    //     let tbody = document.getElementById("invoice-items");
    //     let tr = document.createElement("tr");
    //     tr.innerHTML = `
    //             <td class="py-1.5">
    //                 <input class="min-w-full border-0 text-sm" type="text" placeholder="Description of item/service..."></td>
    //             <td class="p-1.5 w-40 text-center">
    //                 <input class="w-full border-0 text-sm text-center" type="text" value="1" onchange="calculateTotal()"></td>
    //             <td class="p-1.5 w-40 text-center">
    //                 <input class="w-full border-0 text-sm text-center" type="text" value="0" onchange="calculateTotal()"></td>
    //             <td class="p-1.5 w-40 text-right text-sm">0.00</td>
    //             <td class="w-10 py-1.5 flex justify-end items-center text-base">
    //                 <i class="p-1.5 fa fa-trash text-red-500 cursor-pointer ml-2 hover:text-red-700" onclick="removeItem(this)"></i>
    //             </td>
    //         `;
    //     tbody.appendChild(tr);
    // }
    //
    // addItem();

    {{--function removeItem(element) {--}}
    {{--    element.closest("tr").remove();--}}
    {{--    calculateTotal();--}}
    {{--}--}}

    {{--function get_Currency() {--}}
    {{--    return document.getElementById("currency").value;--}}
    {{--}--}}

    {{--function balance_paid() {--}}
    {{--    return document.getElementById("paid").value;--}}
    {{--}--}}

    {{--function isTax() {--}}
    {{--    return document.getElementById("taxField").checked;--}}
    {{--}--}}

    {{--if (!isTax()) {--}}
    {{--    document.getElementById("taxBox").classList.add('hide')--}}
    {{--    document.getElementById("subtotalBox").classList.add('hide')--}}
    {{--} else {--}}
    {{--    document.getElementById("taxBox").classList.remove('hide')--}}
    {{--    document.getElementById("subtotalBox").classList.remove('hide')--}}
    {{--}--}}

    {{--let data = [];--}}
    {{--let balance = 0;--}}
    {{--let paid = 0;--}}
    {{--let total = 0;--}}
    {{--let tax = 0;--}}


    {{--function calculateTotal() {--}}
    {{--    data = [];--}}
    {{--    // let currency = document.getElementById("currency").value;--}}
    {{--    let currency = getCurrency();--}}
    {{--    let rows = document.querySelectorAll("#invoice-items tr");--}}
    {{--    let subtotal = 0;--}}
    {{--    let count = 0;--}}
    {{--    rows.forEach(row => {--}}
    {{--        let item = row.children[0].querySelector("input").value;--}}
    {{--        let qty = row.children[1].querySelector("input").value;--}}
    {{--        let rate = row.children[2].querySelector("input").value;--}}
    {{--        let amount = qty * rate;--}}
    {{--        row.children[3].innerText = `${amount.toFixed(2)}`;--}}
    {{--        subtotal += amount;--}}
    {{--        console.log(item + "/" + qty + "/" + rate + '/' + amount)--}}
    {{--        data[count] = {name: item, qty: qty, rate: rate}--}}
    {{--        count++;--}}
    {{--    });--}}

    {{--    document.getElementById("subtotal").innerText = `${currency} ${subtotal.toFixed(2)}`;--}}
    {{--    tax = 0;--}}
    {{--    if (isTax()) {--}}
    {{--        tax = document.getElementById("tax").value;--}}
    {{--    }--}}

    {{--    total = subtotal + (subtotal * (tax / 100));--}}
    {{--    document.getElementById("total").innerText = `${currency} ${total.toFixed(2)}`;--}}
    {{--    paid = balance_paid();--}}
    {{--    balance = total - paid;--}}
    {{--    document.getElementById("balance").innerText = `${currency} ${balance.toFixed(2)}`;--}}
    {{--}--}}

    {{--serverRequest = new serverRequest();--}}

    {{--//--}}
    {{--function save() {--}}
    {{--    let issue_from = document.getElementById("issueFrom").value;--}}
    {{--    let issue_to = document.getElementById("issueTo").value;--}}
    {{--    let c_Phone = document.getElementById("ContactNumber").value;--}}
    {{--    let c_email = document.getElementById("email").value;--}}
    {{--    let address = document.getElementById("address").value;--}}
    {{--    let invoiceNotes = document.getElementById('invoiceNotes').value;--}}
    {{--    let date = document.getElementById("date").value;--}}
    {{--    let companyName = document.getElementById("company_name").innerText;--}}

    {{--    let server_data = {--}}
    {{--        issue_from: issue_from,--}}
    {{--        name: issue_to,--}}
    {{--        phone: c_Phone,--}}
    {{--        email: c_email,--}}
    {{--        address: address,--}}
    {{--        status:'',--}}
    {{--        company_name: companyName,--}}
    {{--        notes: invoiceNotes,--}}
    {{--        total_amount: total,--}}
    {{--        paid_amount: paid,--}}
    {{--        amount_due: balance,--}}
    {{--        need_tax: isTax(),--}}
    {{--        tax_amount: tax,--}}
    {{--        invoice_date: date,--}}
    {{--        currency: getCurrency(),--}}
    {{--        invoice_number: String({{$invoiceId}}),--}}
    {{--        items: data--}}
    {{--    }--}}
    {{--    calculateTotal();--}}
    {{--    console.log(server_data)--}}
    {{--    serverRequest.url = '/invoice/create';--}}
    {{--    serverRequest.data = server_data;--}}
    {{--    serverRequest.xPost().then((res) => {--}}
    {{--        console.log(res)--}}
    {{--        if (res.success && res.redirect) {--}}
    {{--            window.location.href = res.redirect;--}}
    {{--        }--}}

    {{--    })--}}
    {{--}--}}

    {{--// logo add and change function--}}
    {{--// document.getElementById("logoHolder").addEventListener("change", function (event) {--}}
    {{--//     const file = event.target.files[0]; // Get the selected file--}}
    {{--//     if (file) {--}}
    {{--//         const reader = new FileReader();--}}
    {{--//         reader.onload = function (e) {--}}
    {{--//             let logoContainer = document.querySelector(".logo-container");--}}
    {{--//             let img = document.getElementById("logoPreview");--}}
    {{--//             let button = logoContainer.querySelector("button");--}}
    {{--//             // img.classList.toggle("hide");--}}
    {{--//--}}
    {{--//--}}
    {{--//             if (!img) {--}}
    {{--//                 img = document.createElement("img");--}}
    {{--//                 img.id = "logoPreview";--}}
    {{--//                 img.style.maxWidth = "300px";--}}
    {{--//                 img.style.marginTop = "10px";--}}
    {{--//                 img.style.cursor = "pointer"; // Make it look clickable--}}
    {{--//                 logoContainer.appendChild(img);--}}
    {{--//--}}
    {{--//                 // Add click event to change logo when clicking on the image--}}
    {{--//                 img.addEventListener("click", function () {--}}
    {{--//                     document.getElementById("logoHolder").click();--}}
    {{--//                 });--}}
    {{--//             }--}}
    {{--//             img.src = e.target.result;--}}
    {{--//         };--}}
    {{--//         reader.readAsDataURL(file);--}}
    {{--//     }--}}
    {{--// });--}}

    {{--//--}}
    {{--// document.getElementById("logoCheck").addEventListener("change", function (event) {--}}
    {{--//--}}
    {{--//     let logoSettingsDiv = document.getElementById("logoSettings");--}}
    {{--//     let logoPreview = document.getElementById("logoPreview");--}}
    {{--//     let logoUpBtn = document.getElementById("logoUpBtn");--}}
    {{--//     logoSettingsDiv.classList.toggle("hide");--}}
    {{--//     logoUpBtn.classList.toggle("hide");--}}
    {{--//     logoPreview.classList.toggle("hide");--}}
    {{--// });--}}
    {{--//--}}
    {{--document.getElementById("emailInputCheck").addEventListener("change", function (event) {--}}
    {{--    document.getElementById("email").classList.toggle("hide");--}}
    {{--});--}}
    {{--document.getElementById("taxField").addEventListener("change", function (event) {--}}
    {{--    document.getElementById("taxBox").classList.toggle("hide");--}}
    {{--    document.getElementById("subtotalBox").classList.toggle("hide");--}}
    {{--    calculateTotal();--}}
    {{--});--}}

</script>

<script>
    flatpickr(".datepicker", {});

    const { createApp, ref, computed } = Vue;

    createApp({
        setup() {
            const companyName = ref('Company Name');
            const invoiceId = ref('#INV001');
            const invoiceDate = ref('');
            const from = ref('');
            const to = ref('');
            const address = ref('');
            const contactNumber = ref('');
            const email = ref('');
            const showEmail = ref(false);
            const showTax = ref(false);

            const tax = ref(0);
            const paid = ref(0);
            const currency = ref('BDT');
            const notes = ref('');

            const items = ref([{ name: '', qty: 1, rate: 0 }]);

            const subtotal = computed(() =>
                items.value.reduce((acc, item) => acc + (item.qty * item.rate), 0)
            );
            const taxAmount = computed(() => (subtotal.value * tax.value) / 100);
            const total = computed(() => subtotal.value + taxAmount.value);
            const balance = computed(() => total.value - paid.value);

            const addItem = () => items.value.push({ name: '', qty: 1, rate: 0 });
            const removeItem = (index) => items.value.splice(index, 1);

            const saveInvoice = () => {
                const data = {
                    companyName: companyName.value,
                    invoiceId: invoiceId.value,
                    invoiceDate: invoiceDate.value,
                    from: from.value,
                    to: to.value,
                    address: address.value,
                    contactNumber: contactNumber.value,
                    email: email.value,
                    currency: currency.value,
                    notes: notes.value,
                    items: items.value,
                    tax: tax.value,
                    subtotal: subtotal.value,
                    total: total.value,
                    paid: paid.value,
                    balance: balance.value
                };
                console.log('Invoice data:', data);
                alert('Invoice saved (see console)');
            };

            return {
                companyName, invoiceId, invoiceDate, from, to, address, contactNumber, email, showEmail,
                tax, paid, currency, notes, items, subtotal, taxAmount, total, balance,showTax,
                addItem, removeItem, saveInvoice
            };
        }
    }).mount('#app');
</script>
