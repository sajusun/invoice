<?php
$sn = 0;
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    @include('custom-layouts.headTagContent')
    <title>Invozen Dashboard - Manage Your Invoices</title>
    <meta name="description"
          content="Access your Invozen dashboard to track invoices, manage clients, and monitor payments with ease.">
    <meta name="keywords" content="invoice dashboard, manage invoices, invoice tracker">
    <meta name="robots" content="noindex, follow"> <!-- Prevents indexing but allows following links -->
    <link rel="canonical" href="{{config('app.live_url')}}/dashboard">
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

        .fade-out {
            opacity: 0;
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
    @if (session('welcome_message'))
        <nav id="welcome_message" class="navbar navbar-light bg-light p-3 mb-4 transition-opacity duration-500">
        <span>
            {{ session('welcome_message') }} <strong>{{ Auth::user()->name }}</strong>
        </span>
        </nav>
    @endif

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
{{--    <div class="customer-card hidden" id="customerCard">--}}
{{--        <div class="customer-details">--}}
{{--            <p><strong>Name:</strong> <span id="customerName"></span></p>--}}
{{--            <p><strong>Email:</strong> <span id="customerEmail"></span></p>--}}
{{--            <p><strong>Phone:</strong> <span id="customerPhone"></span></p>--}}
{{--            <p><strong>Address:</strong> <span id="customerAddress"></span></p>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- Customer Info Card -->
    <div class="mt-4 list-view">
        <h4>Recent Invoices </h4>
        <table class="table" id="recentInvoice">
            <thead>
            <tr>
                <th>#</th>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Status</th>
{{--                <th>&nbsp;</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr href="#{{$invoice['invoice_number']}}" class="list" data-id="{{$invoice->customer}}" onclick="toggleDetails(this)">
                    <td class="w-4">{{++$sn}}</td>
                    <td class="left-1">{{$invoice['invoice_number']}}</td>
                    <td>{{$invoice->customer->name}}</td>
                    <td>{{$invoice['total_amount']}}</td>
                    <td>{{$invoice['status']}}</td>
{{--                    <td style="width: 10%;">--}}
{{--                        <a href="{{route('previewInvoice',[$invoice['invoice_number']])}}" class="table-link text-info">--}}
{{--                                            <span class="fa-stack">--}}
{{--                                                <i class="fa fa-square fa-stack-2x"></i>--}}
{{--                                                <i class="fa fa-eye fa-stack-1x fa-inverse"></i>--}}
{{--                                            </span>--}}
{{--                        </a>--}}
{{--                        <a href="#recentInvoice" class="table-link text-info">--}}
{{--                                            <span class="fa-stack">--}}
{{--                                                <i class="fa fa-square fa-stack-2x"></i>--}}
{{--                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>--}}
{{--                                            </span>--}}
{{--                        </a>--}}
{{--                        <a href="#recentInvoice" onclick="confirmDelete('{{route('invoice.delete',[$invoice['invoice_number']])}}')" class="table-link danger">--}}
{{--                                            <span class="fa-stack">--}}
{{--                                                <i class="fa fa-square fa-stack-2x"></i>--}}
{{--                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>--}}
{{--                                            </span>--}}
{{--                        </a>--}}
{{--                    </td>--}}
                </tr>
                <tr class="details-row hide bg-gray-50">
                    <td colspan="6" class="px-3 py-2">
                        <div class="flex justify-around">
                            <div class="text-sm align-content-start text-left">
                                <div><b>Name:</b> {{$invoice->customer['name']}}</div>
                                <div><b>Phone:</b> {{$invoice->customer['phone']}}</div>
                                <div><b>Email:</b> {{$invoice->customer['email']}}</div>

                            </div>
                            <div class="text-sm align-content-start text-left">
                                <div><b>Address:</b> {{$invoice->customer['address']}}</div>
                                <div><b>Date:</b> {{$invoice['invoice_date']}}</div>
{{--                                <div><strong>Email:</strong> saju@example.com</div>--}}
                            </div>
                            <div class="flex items-center">
                                <a href="{{route('previewInvoice',[$invoice['invoice_number']])}}" class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                    <i class="fa fa-eye"></i> View</a>

                                <a href="#" class="bg-green-500 text-white px-3 py-1 m-2 rounded text-xs">
                                    <i class="fa fa-edit"></i> Edit</a>

                                <button class="bg-red-500 text-white px-3 py-1 rounded text-xs"
                                        onclick="confirmDelete('{{route('invoice.delete',[$invoice['invoice_number']])}}')">
                                    <i class="fa fa-trash"></i> Delete</button>
                            </div>
                        </div>

                    </td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    // serverRequest = new serverRequest();
    // let customerId;
    // Select all elements with class "customer-item"
    document.querySelectorAll(".list").forEach(item => {
        item.addEventListener("click", function () {
           // document.getElementById("customerCard").classList.add("hidden");

            // customerId = this.getAttribute("data-id");
          //  const customerData = JSON.parse(this.getAttribute("data-id"));
            document.querySelectorAll(".list td").forEach(el => el.classList.remove("active"));
            this.querySelectorAll("td").forEach(th => th.classList.add("active"));
            // set_name(customerData['name'])
            // set_email(customerData['email'])
            // set_phone(customerData['phone'])
            // set_address(customerData['address'])
            // document.getElementById("customerCard").classList.remove("hidden");

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

    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will permanently delete the invoice.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create and submit a form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'POST';
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    function toggleDetails(row) {
        // Hide all other detail rows first
        document.querySelectorAll(".details-row").forEach(r => r.classList.add("hide"));
        const nextRow = row.nextElementSibling;
        if (nextRow && nextRow.classList.contains("details-row")) {
            // Toggle only the one after the clicked row
            nextRow.classList.toggle("hide");
        }
    }
</script>


@if (session('response'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: '{{session('response')}}',
            title: '{{ session("message") }}',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: false,
        });
    </script>
@endif
@if(session('welcome_message'))
    <script>
        setTimeout(() => {
            const alertBox = document.getElementById("welcome_message");
            if (alertBox) {
                alertBox.classList.add("fade-out"); // apply fade-out style
                setTimeout(() => {
                    alertBox.remove(); // remove after transition
                }, 500); // matches the CSS duration (500ms)
            }
        }, 3000);// 3000 milliseconds = 3 seconds
    </script>
@endif

