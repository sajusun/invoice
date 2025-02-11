<div class="row">
    <div class="col">
        <div class="invoice-container">
            <div class="invoice-header">
                <div class="logo-container">
                    <button id="logoUpBtn" class="py-1 btn btn-light hide"  onclick="document.getElementById('logoHolder').click()">+ Add Your
                        Logo
                    </button>
                    <img id="logoPreview" src="." alt="upload" class="hide"  onclick="document.getElementById('logoHolder').click()"/>
                    <input type="file" id="logoHolder" accept="image/*" class="form-control">
                </div>
                <div>
                    <h2>INVOICE</h2>
                    <input type="text" class="form-control" placeholder="InvoiceID">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Who is this from?">
                    <input type="text" class="form-control mt-2" placeholder="Who is this to?">
                    <input type="text" class="form-control mt-2" placeholder="Contact Number">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control datepicker" placeholder="Date">
                    <input type="text" class="form-control mt-2" placeholder="Payment Terms">
                    {{--                    <input type="text" class="form-control mt-2 datepicker" placeholder="Due Date">--}}
                    {{--                    <input type="text" class="form-control mt-2" placeholder="Phone Number">--}}
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
                    <th></th>
                </tr>
                </thead>
                <tbody id="invoice-items">
                </tbody>
            </table>

            <button class="btn btn-add" onclick="addItem()">+ Line +</button>

            {{--            <div class="mt-3">--}}
            {{--                <h5>Notes</h5>--}}
            {{--                <textarea class="form-control" placeholder="Notes - any relevant information not already covered"></textarea>--}}
            {{--            </div>--}}

            <div class="mt-3">
                <h5>Terms</h5>
                <textarea class="form-control" placeholder="Terms and conditions"></textarea>
            </div>

            <div class="mt-3 text-end">
                <p>Subtotal: <span id="subtotal">BDT 0.00</span></p>
                <p>Tax <input type="number" id="tax" value="0" class="form-control d-inline" style="width: 70px;"
                              onchange="calculateTotal()"> %</p>
                <p>Total: <span id="total">BDT 0.00</span></p>
                <p>Amount Paid: <input type="number" id="paid" value="0" class="form-control d-inline"
                                       style="width: 100px;" onchange="calculateTotal()"></p>
                <p>Balance Due: <span id="balance">BDT 0.00</span></p>
            </div>
        </div>
    </div>
    {{--    side section--}}
    <div class="col-3 side-panel">
        <div class="mt-3">

            <div class="edit-section">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="logoCheck" >
                    <label class="form-check-label" for="logoCheck">
                        add logo in top
                    </label>
                    <div id="logoSettings" class=" py-2 hide">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="nonCircleLogo" checked>
                        <label class="form-check-label" for="nonCircleLogo">
                            non circle logo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="circleLogo">
                        <label class="form-check-label" for="circleLogo">
                            circle logo
                        </label>
                    </div>
                    </div>
                </div>
                <hr>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="emailInputCheck" >
                    <label class="form-check-label" for="emailInputCheck">
                        add email input
                    </label>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <label for="currency">Currency:</label>
            <select id="currency" class="form-select" onchange="calculateTotal()">
                <option value="BDT">BDT</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
            </select>
        </div>
        <div class="mt-3">
            <button id="dl_btn" class="dl-btn">Download</button>
        </div>
    </div>
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
                <td class="description"><input type="text" class="form-control" placeholder="Description of item/service..."></td>
                <td class="item"><input type="text" class="form-control" value="1" onchange="calculateTotal()"></td>
                <td class="quantity"><input type="text" class="form-control" value="0" onchange="calculateTotal()"></td>
                <td class="amount total">${getCurrency()} 0.00</td>
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

    //

    // logo add and change function
    document.getElementById("logoHolder").addEventListener("change", function (event) {
        const file = event.target.files[0]; // Get the selected file
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                let logoContainer = document.querySelector(".logo-container");
                let img = document.getElementById("logoPreview");
                let button = logoContainer.querySelector("button");
                img.classList.toggle("hide");


                if (!img) {
                    img = document.createElement("img");
                    img.id = "logoPreview";
                    img.style.maxWidth = "300px";
                    img.style.marginTop = "10px";
                    img.style.cursor = "pointer"; // Make it look clickable
                    logoContainer.appendChild(img);

                    // Add click event to change logo when clicking on the image
                    img.addEventListener("click", function () {
                        document.getElementById("logoHolder").click();
                    });
                }

                img.src = e.target.result;
                button.classList.toggle("hide");

                // Hide the add logo button after first upload
                // if (button) {
                //     button.style.display = "none";
                // }
            };
            reader.readAsDataURL(file);
        }
    });

//
    document.getElementById("logoCheck").addEventListener("change", function (event) {
        this.get
        let logoSettingsDiv = document.getElementById("logoSettings");
        let logoPreview = document.getElementById("logoPreview");
        let logoUpBtn = document.getElementById("logoUpBtn");
        logoSettingsDiv.classList.toggle("hide");
        logoUpBtn.classList.toggle("hide");
        logoPreview.classList.toggle("hide");

    });
</script>

