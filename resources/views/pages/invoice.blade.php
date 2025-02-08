<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invoice Generator</title>
</head>
<body>
@include('custom-layouts.navbar')
<div style="padding:2.5rem 1rem 2rem">
    @include('custom-layouts.invoice')
</div>
@include('custom-layouts.footer')
{{--<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>--}}
{{--<script>--}}
{{--    flatpickr(".datepicker", {});--}}

{{--function getCurrency() {--}}
{{--    return document.getElementById("currency").value;--}}
{{--}--}}

{{--    function addItem() {--}}
{{--        let tbody = document.getElementById("invoice-items");--}}
{{--        let tr = document.createElement("tr");--}}
{{--        tr.innerHTML = `--}}
{{--                <td><input type="text" class="form-control" placeholder="Description of item/service..."></td>--}}
{{--                <td><input type="number" class="form-control" value="1" onchange="calculateTotal()"></td>--}}
{{--                <td><input type="number" class="form-control" value="0" onchange="calculateTotal()"></td>--}}
{{--                <td class="amount">${getCurrency()} 0.00</td>--}}
{{--                <td style="position: relative"><span class="remove-btn" onclick="removeItem(this)">&#128465;</span></td>--}}
{{--            `;--}}
{{--        tbody.appendChild(tr);--}}
{{--    }--}}
{{--    addItem();--}}

{{--    function removeItem(element) {--}}
{{--        element.closest("tr").remove();--}}
{{--        calculateTotal();--}}
{{--    }--}}

{{--    function calculateTotal() {--}}
{{--        let currency = document.getElementById("currency").value;--}}
{{--        let rows = document.querySelectorAll("#invoice-items tr");--}}
{{--        let subtotal = 0;--}}
{{--        rows.forEach(row => {--}}
{{--            let qty = row.children[1].querySelector("input").value;--}}
{{--            let rate = row.children[2].querySelector("input").value;--}}
{{--            let amount = qty * rate;--}}
{{--            row.children[3].innerText = `${currency} ${amount.toFixed(2)}`;--}}
{{--            subtotal += amount;--}}
{{--        });--}}
{{--        document.getElementById("subtotal").innerText = `${currency} ${subtotal.toFixed(2)}`;--}}
{{--        let tax = document.getElementById("tax").value;--}}
{{--        let total = subtotal + (subtotal * (tax / 100));--}}
{{--        document.getElementById("total").innerText = `${currency} ${total.toFixed(2)}`;--}}
{{--        let paid = document.getElementById("paid").value;--}}
{{--        let balance = total - paid;--}}
{{--        document.getElementById("balance").innerText = `${currency} ${balance.toFixed(2)}`;--}}
{{--    }--}}
{{--</script>--}}
</body>
</html>
