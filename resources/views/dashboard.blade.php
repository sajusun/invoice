<!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Dashboard</title>
    <style>
        /* Customer Info Card */
        .customer-card {
            display: block;
            width: auto;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            margin: 1rem auto;
        }

        .customer-card.hidden {
            display: none;
        }
        .customer-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .customer-details {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
        }

        .customer-details h3 {
            margin: 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
{{--navbar--}}
@include('custom-layouts.navbar')
{{--left site bar--}}
<div class="sidebar">
    @include('custom-layouts.sidebar_dashboard')
</div>

<div class="main-content">
    <nav class="navbar navbar-light bg-light p-3 mb-4">
        <span>
            {{ __('Welcome') }}, <strong>{{ Auth::user()->name }}</strong>
        </span>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total Invoices</h6>
                <p>{{$num_of_invoices}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Pending Payments</h6>
                <p>{{$status}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6>Total Revenue</h6>
                <p>{{$total}}</p>
            </div>
        </div>
    </div>
    <!-- Customer Info Card -->
    <div class="customer-card hidden" id="customerCard">
        <div class="customer-details">
            <p><strong>Name:</strong> <span id="customerName"></span></p>
            <p><strong>Email:</strong> <span id="customerEmail"></span></p>
            <p><strong>Phone:</strong> <span id="customerPhone"></span></p>
            <p><strong>Address:</strong> <span id="customerAddress"></span></p>
        </div>
    </div>
    <!-- Customer Info Card -->

    <div class="mt-4 list-view">
        <h4>Recent Invoices</h4>
        <table class="table">
            <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr class="list" data-id="{{$invoice->customer}}">
                    <td>{{$invoice['invoice_number']}}</td>
                    <td>{{$invoice->customer->name}}</td>
                    <td>{{$invoice['total_amount']}}</td>
                    <td>{{$invoice['status']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</html>
<script>
    function set_name(data) {
        document.getElementById('customerName').innerText = data;
    }

    function set_email(data) {
        document.getElementById('customerEmail').innerText = data;
    }

    function set_phone(data) {
        document.getElementById('customerPhone').innerText = data;
    }

    function set_address(data) {
        document.getElementById('customerAddress').innerText = data;
    }

    serverRequest = new serverRequest();
    let customerId;
    // Select all elements with class "customer-item"
    document.querySelectorAll(".list").forEach(item => {
        item.addEventListener("click", function () {
            document.getElementById("customerCard").classList.add("hidden");

            // customerId = this.getAttribute("data-id");
            const customerData = JSON.parse(this.getAttribute("data-id"));
            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));
            this.querySelectorAll("td").forEach(th => th.classList.add("active"));
            set_name(customerData['name'])
            set_email(customerData['email'])
            set_phone(customerData['phone'])
            set_address(customerData['address'])
            document.getElementById("customerCard").classList.remove("hidden");

            // // console.log(customerId)
            // serverRequest.url = `http://localhost:8000/dashboard/customers/${customerId}`;
            // serverRequest.xGet().then((response) => {
            //     console.log(response['customer_data'])
            //     let object = response['customer_data'];
            //     // set_invoices(object.invoices.length)
            //     set_name(response['customer_data']['name'])
            //     set_email(response['customer_data']['email'])
            //     set_phone(response['customer_data']['phone'])
            //     set_address(response['customer_data']['address'])
            //
            //     document.getElementById("customerCard").classList.remove("hidden");
            //
            // })
        });
    });
</script>
