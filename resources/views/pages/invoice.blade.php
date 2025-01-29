<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body { padding: 20px; }
        .invoice-container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .invoice-header { display: flex; justify-content: space-between; align-items: center; }
        .table th { background: #1b2a4e; color: #fff; }
        .btn-add { background: #198754; color: white; }
        .remove-btn { display: none; cursor: pointer; color: red; }
        /*tr:hover .remove-btn { display: inline; }*/
        tr:hover .remove-btn { display: inline-block;position: absolute;right: 0}

    </style>
</head>
<body>
<div class="row">
<div class="col">
    <div class="invoice-container">
        <div class="invoice-header">
            <div><button class="btn btn-light">+ Add Your Logo</button></div>
            <div>
                <h2>INVOICE</h2>
                <input type="text" class="form-control" placeholder="# 1">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Who is this from?">
                <input type="text" class="form-control mt-2" placeholder="Who is this to?">
                <input type="text" class="form-control mt-2" placeholder="(optional)">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control datepicker" placeholder="Date">
                <input type="text" class="form-control mt-2" placeholder="Payment Terms">
                <input type="text" class="form-control mt-2 datepicker" placeholder="Due Date">
                <input type="text" class="form-control mt-2" placeholder="Phone Number">
            </div>
        </div>
{{----}}

        <table class="table mt-3">
            <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Amount</th>
                <th> </th>

            </tr>
            </thead>
            <tbody id="invoice-items">
            </tbody>
        </table>

        <button class="btn btn-add" onclick="addItem()">+ Line Item</button>

        <div class="mt-3">
            <h5>Notes</h5>
            <textarea class="form-control" placeholder="Notes - any relevant information not already covered"></textarea>
        </div>

        <div class="mt-3">
            <h5>Terms</h5>
            <textarea class="form-control" placeholder="Terms and conditions"></textarea>
        </div>

        <div class="mt-3 text-end">
            <p>Subtotal: <span id="subtotal">BDT 0.00</span></p>
            <p>Tax <input type="number" id="tax" value="0" class="form-control d-inline" style="width: 70px;" onchange="calculateTotal()"> %</p>
            <p>Total: <span id="total">BDT 0.00</span></p>
            <p>Amount Paid: <input type="number" id="paid" value="0" class="form-control d-inline" style="width: 100px;" onchange="calculateTotal()"></p>
            <p>Balance Due: <span id="balance">BDT 0.00</span></p>
        </div>
    </div>
</div>
{{--    side section--}}
<div class="col-3">
    <div class="mt-3">
        <label for="currency">Currency:</label>
        <select id="currency" class="form-select" onchange="calculateTotal()">
            <option value="BDT">BDT</option>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
        </select>
    </div></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".datepicker", {});

function getCurrency() {
    return document.getElementById("currency").value;
}

    function addItem() {
        let tbody = document.getElementById("invoice-items");
        let tr = document.createElement("tr");
        tr.innerHTML = `
                <td><input type="text" class="form-control" placeholder="Description of item/service..."></td>
                <td><input type="number" class="form-control" value="1" onchange="calculateTotal()"></td>
                <td><input type="number" class="form-control" value="0" onchange="calculateTotal()"></td>
                <td class="amount">${getCurrency()} 0.00</td>
                <td style="position: relative"><span class="remove-btn" onclick="removeItem(this)">&#128465;</span></td>
            `;
        tbody.appendChild(tr);
    }
    addItem();

    function removeItem(element) {
        element.closest("tr").remove();
        calculateTotal();
    }

    function calculateTotal() {
        let currency = document.getElementById("currency").value;
        let rows = document.querySelectorAll("#invoice-items tr");
        let subtotal = 0;
        rows.forEach(row => {
            let qty = row.children[1].querySelector("input").value;
            let rate = row.children[2].querySelector("input").value;
            let amount = qty * rate;
            row.children[3].innerText = `${currency} ${amount.toFixed(2)}`;
            subtotal += amount;
        });
        document.getElementById("subtotal").innerText = `${currency} ${subtotal.toFixed(2)}`;
        let tax = document.getElementById("tax").value;
        let total = subtotal + (subtotal * (tax / 100));
        document.getElementById("total").innerText = `${currency} ${total.toFixed(2)}`;
        let paid = document.getElementById("paid").value;
        let balance = total - paid;
        document.getElementById("balance").innerText = `${currency} ${balance.toFixed(2)}`;
    }
</script>
</body>
</html>
