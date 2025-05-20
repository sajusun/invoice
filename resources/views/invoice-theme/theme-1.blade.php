<!DOCTYPE html>
<html lang="en">
<head>
  @include('custom-layouts.headTagContent')
    <title>Editable Invoice Builder</title>
</head>

<body class="bg-gray-100 p-6">

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Invoice</h1>
            <input type="text" id="invoiceNumber" value="505187003" class="text-sm text-gray-600 w-32 border-b focus:outline-none"/>
        </div>
        <div class="text-right">
            <input type="date" id="invoiceDate" value="2025-05-14" class="text-sm text-gray-600 border-b focus:outline-none"/>
            <span class="inline-block bg-amber-400 text-white text-xs font-semibold px-3 py-1 rounded-full ml-2">PENDING</span>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <!-- Billed To -->
        <div>
            <h2 class="font-semibold mb-2">Billed To:</h2>
            <div class="space-y-2">
                <input type="text" placeholder="Name" class="w-full border rounded p-1 text-sm" />
                <textarea rows="2" placeholder="Address" class="w-full border rounded p-1 text-sm"></textarea>
                <input type="text" placeholder="Phone Number" class="w-full border rounded p-1 text-sm" />
                <input type="email" placeholder="Email (optional)" class="w-full border rounded p-1 text-sm" />
            </div>
        </div>

        <!-- From -->
        <div>
            <h2 class="font-semibold mb-2">From:</h2>
            <div class="space-y-2">
                <input type="text" value="invozen.com" class="w-full border rounded p-1 text-sm" />
                <textarea rows="2" placeholder="Company Address" class="w-full border rounded p-1 text-sm"></textarea>
                <input type="text" value="+8801234567890" class="w-full border rounded p-1 text-sm" />
                <input type="email" value="support@invozen.com" class="w-full border rounded p-1 text-sm" />
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto mt-6">
        <table class="w-full border-collapse" id="invoiceTable">
            <thead>
            <tr class="bg-gray-100 text-left text-sm">
                <th class="border p-2">#</th>
                <th class="border p-2">Item</th>
                <th class="border p-2 text-right">Qty</th>
                <th class="border p-2 text-right">Price</th>
                <th class="border p-2 text-right">Total</th>
                <th class="border p-2 text-center">Action</th>
            </tr>
            </thead>
            <tbody id="items">
            <tr>
                <td class="border p-2">1</td>
                <td class="border p-2"><input value="item1" class="w-full border-b focus:outline-none"/></td>
                <td class="border p-2 text-right"><input type="number" value="1" class="w-16 text-right border-b focus:outline-none qty"/></td>
                <td class="border p-2 text-right"><input type="number" value="10" class="w-20 text-right border-b focus:outline-none price"/></td>
                <td class="border p-2 text-right total">10.00</td>
                <td class="border p-2 text-center"><button onclick="removeRow(this)" class="text-red-500">✖</button></td>
            </tr>
            </tbody>
        </table>
    </div>

    <button onclick="addItem()" class="mt-3 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">+ Add Item</button>

    <!-- Tax + Totals -->
    <div class="text-right space-y-1 mt-6">
        <p>Subtotal: <span class="font-medium" id="subtotal">0.00 BDT</span></p>
        <p>Tax (<input type="number" id="taxRate" value="2" class="w-12 text-right border-b focus:outline-none"/>%): <span class="font-medium" id="taxAmount">0.00 BDT</span></p>
        <p class="text-lg font-bold">Total: <span id="total">0.00 BDT</span></p>
        <p class="text-red-500 font-semibold">Due: <span id="dueAmount">0.00 BDT</span></p>
    </div>

    <p class="text-gray-600 text-sm mt-4">Thank you for your business!</p>
</div>

<script>
    function calculateInvoice() {
        const rows = document.querySelectorAll("#items tr");
        let subtotal = 0;
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector(".qty").value) || 0;
            const price = parseFloat(row.querySelector(".price").value) || 0;
            const total = qty * price;
            row.querySelector(".total").textContent = total.toFixed(2);
            subtotal += total;
        });
        const taxRate = parseFloat(document.getElementById("taxRate").value) || 0;
        const taxAmount = subtotal * (taxRate / 100);
        const totalAmount = subtotal + taxAmount;
        const dueAmount = totalAmount - 500; // Example paid amount

        document.getElementById("subtotal").textContent = `${subtotal.toFixed(2)} BDT`;
        document.getElementById("taxAmount").textContent = `${taxAmount.toFixed(2)} BDT`;
        document.getElementById("total").textContent = `${totalAmount.toFixed(2)} BDT`;
        document.getElementById("dueAmount").textContent = `${dueAmount.toFixed(2)} BDT`;
    }

    function addItem() {
        const tableBody = document.getElementById("items");
        const rowCount = tableBody.rows.length + 1;
        const row = document.createElement("tr");
        row.innerHTML = `
        <td class="border p-2">${rowCount}</td>
        <td class="border p-2"><input value="item${rowCount}" class="w-full border-b focus:outline-none"/></td>
        <td class="border p-2 text-right"><input type="number" value="1" class="w-16 text-right border-b focus:outline-none qty"/></td>
        <td class="border p-2 text-right"><input type="number" value="0" class="w-20 text-right border-b focus:outline-none price"/></td>
        <td class="border p-2 text-right total">0.00</td>
        <td class="border p-2 text-center"><button onclick="removeRow(this)" class="text-red-500">✖</button></td>
      `;
        tableBody.appendChild(row);
        attachInputListeners();
        calculateInvoice();
    }

    function removeRow(button) {
        button.closest("tr").remove();
        updateRowNumbers();
        calculateInvoice();
    }

    function updateRowNumbers() {
        const rows = document.querySelectorAll("#items tr");
        rows.forEach((row, index) => {
            row.querySelector("td").textContent = index + 1;
        });
    }

    function attachInputListeners() {
        document.querySelectorAll(".qty, .price, #taxRate").forEach(input => {
            input.removeEventListener("input", calculateInvoice);
            input.addEventListener("input", calculateInvoice);
        });
    }

    attachInputListeners();
    calculateInvoice();
</script>

</body>
</html>
